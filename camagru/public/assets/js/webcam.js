const video = document.getElementById('video');
const captureButton = document.getElementById('capture-btn');

navigator.mediaDevices.getUserMedia({ video: true, audio: false })
.then(stream => { video.srcObject = stream; })
.catch(err => { console.error(err); });

captureButton.addEventListener('click', capturePhoto);

function capturePhoto() {

	alert("click");

	const canvas = document.getElementById('canvas');
	const context = canvas.getContext('2d');

	canvas.width = video.videoWidth;
	canvas.height = video.videoHeight;

	context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

	const photoDataUrl = canvas.toDataURL('image/jpeg');
}

let selectedSticker = null;

document.querySelectorAll('.sticker').forEach(sticker => {
    sticker.addEventListener('click', () => {

		alert("click stickers");
        selectedSticker = sticker.src;

        const preview = document.getElementById('previewSticker');

        preview.src = selectedSticker;
        preview.hidden = false;
    });
});
