document.addEventListener("DOMContentLoaded", () => {

	const video = document.getElementById('video');
	const captureButton = document.getElementById('capture-btn');

	updateGallery();

	let camera_ready = 0;

	navigator.mediaDevices.getUserMedia({video: { width: 640, height: 480 }})
	.then(stream => { video.srcObject = stream;  camera_ready = 1;})
	.catch(err => { console.error(err); });

	captureButton.addEventListener('click', capturePhoto);

	function capturePhoto() {

		if (!selectedSticker || !camera_ready)
			return ;

		const stickers = [];

		const canvas = document.getElementById('canvas');
		const context = canvas.getContext('2d');

		canvas.width = video.videoWidth;
		canvas.height = video.videoHeight;

		context.drawImage(video, 0, 0, canvas.width, canvas.height);

		const photoDataUrl = canvas.toDataURL('image/jpeg');

		document.querySelectorAll('.overlay-sticker').forEach(sticker => {
			stickers.push({
				src: sticker.src,
				x: sticker.dataset.x,
				y: sticker.dataset.y
			});
		});

		fetch('/webcam/capture', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				image: photoDataUrl,
				stickers: stickers
			})
		})
		.then(res => res.text())
		// .then(text => console.log(text))
		.then(() => updateGallery())
		.catch(err => console.error(err));
	}

	let selectedSticker = 0;

	document.querySelectorAll('.sticker').forEach(sticker => {
		sticker.addEventListener('click', () => {

			if (selectedSticker > 50)
					return ;

				selectedSticker++;

				captureButton.disabled = false;

				const img = document.createElement("img");
				img.src = sticker.src;
				img.className = "overlay-sticker";
				img.dataset.x = 0;
				img.dataset.y = 0;

				container.appendChild(img);
			});
		});

	function updateGallery()
	{
		fetch('/thumbnails')
		.then(response => response.text())
		.then(html => {
			document.getElementById('thumbnails').innerHTML = html;
		});
	}

	document.getElementById('thumbnails').addEventListener('click', (e) => {
		if (e.target.tagName === 'IMG') {
			fetch('/deleteImage', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				image: e.target.src
			})
		})
		.then(res => res.text())
		// .then(text => console.log(text))
		.then(() => updateGallery())
		.catch(err => console.error(err));
		}
	});
});
