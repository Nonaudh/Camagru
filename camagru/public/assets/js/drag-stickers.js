const sticker = document.getElementById('previewSticker');
const container = document.getElementById('camera-container');

let isDragging = false;
let offsetX = 0;
let offsetY = 0;

sticker.addEventListener('mousedown', (e) => {
	e.preventDefault();
    isDragging = true;

    // offsetX = e.clientX - sticker.offsetLeft;
    // offsetY = e.clientY - sticker.offsetTop;

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

	// let x = e.clientX - container.getBoundingClientRect().left - offsetX;
    // let y = e.clientY - container.getBoundingClientRect().top - offsetY;

	x = Math.max(0, Math.min(x, container.clientWidth - sticker.offsetWidth));
    y = Math.max(0, Math.min(y, container.clientHeight - sticker.offsetHeight));

    sticker.style.left = x + "px";
    sticker.style.top = y + "px";

	console.log(`x=${x}, y=${y}`);
});

document.addEventListener('mouseup', () => {
    isDragging = false;
});
