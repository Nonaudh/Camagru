document.addEventListener("DOMContentLoaded", () => {

	const captureButton = document.getElementById('capture-btn');

	updateGallery();

	const fileInput = document.getElementById("file");
	const image = document.getElementById("image");

	let selectedFile = null;
	let imageUrl = null;

	fileInput.addEventListener("change", () => {
		const file = fileInput.files[0];

		if (!file)
			return;

		if (!file.type.startsWith("image/")) {
			alert("Not an image bruh");
			return;
		}

		selectedFile = file;

		if (imageUrl) {
			URL.revokeObjectURL(imageUrl);
		}

		imageUrl = URL.createObjectURL(file);
		image.src = imageUrl;
	});


	// captureButton.addEventListener('click', capturePhoto);

	// function capturePhoto() {

	// 	if (!selectedSticker || !camera_ready)
	// 		return ;

	// 	const stickers = [];

	// 	const canvas = document.getElementById('canvas');
	// 	const context = canvas.getContext('2d');

	// 	canvas.width = video.videoWidth;
	// 	canvas.height = video.videoHeight;

	// 	context.drawImage(video, 0, 0, canvas.width, canvas.height);

	// 	const photoDataUrl = canvas.toDataURL('image/jpeg');

	// 	document.querySelectorAll('.overlay-sticker').forEach(sticker => {
	// 		stickers.push({
	// 			src: sticker.src,
	// 			x: sticker.dataset.x,
	// 			y: sticker.dataset.y
	// 		});
	// 	});

	// 	fetch('/webcam/capture', {
	// 		method: 'POST',
	// 		headers: {
	// 			'Content-Type': 'application/json'
	// 		},
	// 		body: JSON.stringify({
	// 			image: photoDataUrl,
	// 			stickers: stickers
	// 		})
	// 	})
	// 	.then(res => res.text())
	// 	// .then(text => console.log(text))
	// 	.then(() => updateGallery())
	// 	.catch(err => console.error(err));
	// }

	// let selectedSticker = 0;

	// document.querySelectorAll('.sticker').forEach(sticker => {
	// 	sticker.addEventListener('click', () => {

	// 		if (selectedSticker > 50)
	// 				return ;

	// 			selectedSticker++;

	// 			captureButton.disabled = false;

	// 			const img = document.createElement("img");
	// 			img.src = sticker.src;
	// 			img.className = "overlay-sticker";
	// 			img.dataset.x = 0;
	// 			img.dataset.y = 0;

	// 			container.appendChild(img);
	// 		});
	// 	});

	// document.getElementById('uploadForm').addEventListener('submit', function (e) {
	// 	e.preventDefault();

	// 	const form = e.target;
	// 	const formData = new FormData(form);

	// 	const stickers = [];

	// 	document.querySelectorAll('.overlay-sticker').forEach(sticker => {
	// 		stickers.push({
	// 			src: sticker.src,
	// 			x: sticker.dataset.x,
	// 			y: sticker.dataset.y
	// 		});
	// 	});

	// 	formData.append("stickers", JSON.stringify(stickers));

	// 	fetch(form.action, {
	// 		method: 'POST',
	// 		body: formData
	// 	})
	// 	.then(response => response.text())
	// 	// .then(text => console.log(text))
	// 	.then(data => {updateGallery();})
	// 	.catch(error => {console.error('Upload error');});
	// });

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
