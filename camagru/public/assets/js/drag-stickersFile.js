const container = document.getElementById('camera-container');
const imageRect = null;

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
	if (!isDragging || !currentTarget)
		return ;

	const imageRect = image.getBoundingClientRect(); 
	const containerRect = container.getBoundingClientRect();
	const stickerRect = currentTarget.getBoundingClientRect();

	let x = e.clientX - imageRect.left - Number(currentTarget.dataset.offsetX);
	let y = e.clientY - imageRect.top - Number(currentTarget.dataset.offsetY);

	x = Math.max(0, Math.min(x, imageRect.width - stickerRect.width));
	y = Math.max(0, Math.min(y, imageRect.height - stickerRect.height));

	currentTarget.style.left = (imageRect.left - containerRect.left + x) + 'px';

    currentTarget.style.top = (imageRect.top - containerRect.top + y) + 'px';

    currentTarget.dataset.x = x / imageRect.width;
    currentTarget.dataset.y = y / imageRect.height;
});

document.addEventListener('pointerup', () => {
    isDragging = false;
	currentTarget = null;
});

// function updateStickerPosition() {
//     // const containerRect = container.getBoundingClientRect();
//     const imageRect = image.getBoundingClientRect(); 
// 	const allStickers = document.querySelectorAll('.overlay-sticker');

// 	allStickers.forEach(sticker => {
// 		const x = sticker.dataset.x * imageRect.width;
// 		const y = sticker.dataset.y * imageRect.height;

// 		sticker.style.left = x + "px";
// 		sticker.style.top = y + "px";
// 	});
// }

function updateStickerPosition() {
    const imageRect = image.getBoundingClientRect();
    const containerRect = container.getBoundingClientRect();

    const allStickers = document.querySelectorAll('.overlay-sticker');

    allStickers.forEach(sticker => {
        const x = Number(sticker.dataset.x) * imageRect.width;
        const y = Number(sticker.dataset.y) * imageRect.height;

        sticker.style.left =
            (imageRect.left - containerRect.left + x) + 'px';

        sticker.style.top =
            (imageRect.top - containerRect.top + y) + 'px';
    });
}

window.addEventListener('resize', updateStickerPosition);
