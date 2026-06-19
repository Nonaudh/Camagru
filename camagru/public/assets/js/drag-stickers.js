const sticker = document.getElementById('previewSticker');
const container = document.getElementById('camera-container');

let isDragging = false;
let offsetX = 0;
let offsetY = 0;

sticker.addEventListener('mousedown', (e) => {
	e.preventDefault();
    isDragging = true;

    const rect = sticker.getBoundingClientRect();
    offsetX = e.clientX - rect.left;
    offsetY = e.clientY - rect.top;
});

document.addEventListener('mousemove', (e) => {
    if (!isDragging)
        return;

    const containerRect = container.getBoundingClientRect();

	let x = e.clientX - containerRect.left - offsetX;
    let y = e.clientY - containerRect.top - offsetY;

	x = Math.max(0, Math.min(x, container.clientWidth - sticker.offsetWidth));
    y = Math.max(0, Math.min(y, container.clientHeight - sticker.offsetHeight));

	const xPercent = x / containerRect.width;
    const yPercent = y / containerRect.height;

    sticker.dataset.x = xPercent;
    sticker.dataset.y = yPercent;

    sticker.style.left = x + "px";
    sticker.style.top = y + "px";
});

document.addEventListener('mouseup', () => {
    isDragging = false;
});

function updateStickerPosition() {
    const containerRect = container.getBoundingClientRect();

    const x = sticker.dataset.x * containerRect.width;
    const y = sticker.dataset.y * containerRect.height;

    sticker.style.left = x + "px";
    sticker.style.top = y + "px";
}

window.addEventListener('resize', updateStickerPosition);
