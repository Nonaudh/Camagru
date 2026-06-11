const video = document.getElementById('video');
const captureButton = document.getElementById('capture-btn');

navigator.mediaDevices.getUserMedia({ video: true, audio: false })
.then(stream => { video.srcObject = stream; })
.catch(err => { console.error(err); });

captureButton.addEventListener('click', capturePhoto);

function capturePhoto() {

	if (!selectedSticker)
		return ;

	const canvas = document.getElementById('canvas');
	const context = canvas.getContext('2d');

	canvas.width = video.videoWidth;  // 640
	canvas.height = video.videoHeight; // 480

	context.drawImage(video, 0, 0, canvas.width, canvas.height);

	const photoDataUrl = canvas.toDataURL('image/jpeg');

	fetch('/webcam/capture', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify({
			image: photoDataUrl,
			sticker: selectedSticker,
			x: sticker.style.left,
			y: sticker.style.top
		})
	})
	.then(res => res.text())
	.then(data => console.log(data))
	.catch(err => console.error(err));
	alert("sent");
}

let selectedSticker = null;

document.querySelectorAll('.sticker').forEach(sticker => {
	sticker.addEventListener('click', () => {
		
			selectedSticker = sticker.src;
			
			const preview = document.getElementById('previewSticker');
			
			preview.src = selectedSticker;
			preview.hidden = false;
		});
	});
	