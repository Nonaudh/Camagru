const container = document.getElementById('camera-container');

let isDragging = false;
let currentTarget = null;

container.addEventListener('pointerdown', (e) => {
	if (e.target.tagName === 'IMG') 
	{
		currentTarget = e.target;
		e.preventDefault();
		isDragging = true;

		const rect = e.target.getBoundingClientRect();
		e.target.dataset.offsetX = e.clientX - rect.left;
		e.target.dataset.offsetY = e.clientY - rect.top;
	}
});

document.addEventListener('pointermove', (e) => {
	if (!isDragging)
		return ;

	const containerRect = container.getBoundingClientRect();
	const stickerRect = currentTarget.getBoundingClientRect();

	let x = e.clientX - containerRect.left - currentTarget.dataset.offsetX;
	let y = e.clientY - containerRect.top - currentTarget.dataset.offsetY;

	x = Math.max(0, Math.min(x, container.clientWidth - stickerRect.width));
	y = Math.max(0, Math.min(y, container.clientHeight - stickerRect.height));

	const xPercent = x / containerRect.width;
	const yPercent = y / containerRect.height;

	currentTarget.dataset.x = xPercent;
	currentTarget.dataset.y = yPercent;

	currentTarget.style.left = x + "px";
	currentTarget.style.top = y + "px";
});

document.addEventListener('pointerup', () => {
    isDragging = false;
	currentTarget = null;
});

function updateStickerPosition() {
    const containerRect = container.getBoundingClientRect();
	const allStickers = document.querySelectorAll('.overlay-sticker');

	allStickers.forEach(sticker => {
		const x = sticker.dataset.x * containerRect.width;
		const y = sticker.dataset.y * containerRect.height;

		sticker.style.left = x + "px";
		sticker.style.top = y + "px";
	});
}

window.addEventListener('resize', updateStickerPosition);
