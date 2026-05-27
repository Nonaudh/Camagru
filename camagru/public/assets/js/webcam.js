var videoElement = document.querySelector("#videoElement");
const canvasElement = document.getElementById('canvasElement');
const photoElement = document.getElementById('photoElement');
const captureButton = document.getElementById('captureButton');

if (navigator.mediaDevices.getUserMedia)
{
	navigator.mediaDevices.getUserMedia({video : true})
	.then(function (stream) {
		videoElement.srcObject = stream;
	})
	.catch(function (error) {
		console.log("Something went wrong!");
	});
}

function capturePhoto() {
	canvasElement.width = videoElement.videoWidth;
    canvasElement.height = videoElement.videoHeight;
    canvasElement.getContext('2d').drawImage(videoElement, 0, 0);
    const photoDataUrl = canvasElement.toDataURL('image/jpeg');
    photoElement.src = photoDataUrl;
    photoElement.style.display = 'block';
}

captureButton.addEventListener('click', capturePhoto);
