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

	const videoRect = video.getBoundingClientRect();

	console.log(videoRect);

	const x = e.clientX - videoRect.left - offsetX;
    const y = e.clientY - videoRect.top - offsetY;

    stickers.style.left = `${x}px`;
    stickers.style.top = `${y}px`;

	console.log(stickers.style.left);
	console.log(stickers.style.top);
});

document.addEventListener('mouseup', () => {
    isDragging = false;
});
