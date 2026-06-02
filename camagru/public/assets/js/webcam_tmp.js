const videoElement = document.getElementById("video");
const canvasElement = document.getElementById('canvas');
const photoElement = document.getElementById('photo');
const captureButton = document.getElementById('capture-btn');

if (navigator.mediaDevices.getUserMedia)
{
	navigator.mediaDevices.getUserMedia({video : true})
	.then(function (stream) {
		videoElement.srcObject = stream;
	})
	.catch(function (error) {
		console.error(error);
	});
}

function capturePhoto() {
	canvasElement.width = videoElement.videoWidth;
    canvasElement.height = videoElement.videoHeight;

    const context = canvasElement.getContext('2d');
	
	context.drawImage(videoElement, 0, 0);
	
	console.log(captureButton);

    const photoDataUrl = canvasElement.toDataURL('image/jpeg');

    photoElement.src = photoDataUrl;

    photoElement.style.display = 'block';
	videoElement.style.display = 'none';
}

captureButton.addEventListener('click', capturePhoto);
