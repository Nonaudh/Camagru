const stickers = document.getElementById('previewSticker');
// const video = document.getElementById('video');

let isDragging = false;
let offsetX = 0;
let offsetY = 0;

stickers.addEventListener('mousedown', (e) => {
	e.preventDefault();
    isDragging = true;

    offsetX = e.clientX - stickers.offsetLeft;
    offsetY = e.clientY - stickers.offsetTop;
});

document.addEventListener('mousemove', (e) => {
    if (!isDragging)
        return;

	const x = e.clientX - offsetX;
    const y = e.clientY - offsetY;

    stickers.style.left = `${x}px`;
    stickers.style.top = `${y}px`;
});

document.addEventListener('mouseup', () => {
    isDragging = false;
});
