
// const sticker = document.getElementById('previewSticker');
const container = document.getElementById('camera-container');

let isDragging = false;
let currentTarget = null;
// let offsetX = 0;
// let offsetY = 0;

container.addEventListener('mousedown', (e) => {
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

document.addEventListener('mousemove', (e) => {
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

document.addEventListener('mouseup', () => {
    isDragging = false;
	currentTarget = null;
});

// sticker.addEventListener('mousedown', (e) => {
// 	e.preventDefault();
//     isDragging = true;

//     const rect = sticker.getBoundingClientRect();
//     offsetX = e.clientX - rect.left;
//     offsetY = e.clientY - rect.top;
// });

// document.addEventListener('mousemove', (e) => {
//     if (!isDragging)
//         return;

//     const containerRect = container.getBoundingClientRect();
// 	const stickerRect = sticker.getBoundingClientRect();

// 	let x = e.clientX - containerRect.left - offsetX;
//     let y = e.clientY - containerRect.top - offsetY;

// 	// console.log(sticker.width , sticker.height);

// 	x = Math.max(0, Math.min(x, container.clientWidth - stickerRect.width));
//     y = Math.max(0, Math.min(y, container.clientHeight - stickerRect.height));

// 	const xPercent = x / containerRect.width;
//     const yPercent = y / containerRect.height;

//     sticker.dataset.x = xPercent;
//     sticker.dataset.y = yPercent;

//     sticker.style.left = x + "px";
//     sticker.style.top = y + "px";
// });

// document.addEventListener('mouseup', () => {
//     isDragging = false;
// });

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
