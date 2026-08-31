document.addEventListener("DOMContentLoaded", () => {

	const captureButton = document.getElementById('capture-btn');

	updateGallery();

	const fileInput = document.getElementById("fileInput");
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

		const allStickers = document.querySelectorAll('.overlay-sticker');

		allStickers.forEach(sticker => {
			sticker.remove();
		});

		selectedFile = file;

		if (imageUrl)
			URL.revokeObjectURL(imageUrl);

		imageUrl = URL.createObjectURL(file);
		image.src = imageUrl;

		captureButton.disabled = false;
	});

	function getImageWidth()
	{
		const maxWidth = 640;
		const maxHeight = 480;

		if (image.naturalWidth < maxWidth && image.naturalHeight < maxHeight)
			return (image.naturalWidth);

		const scale = Math.min(
		maxWidth / image.naturalWidth,
		maxHeight / image.naturalHeight
		);

		const width = image.naturalWidth * scale;
		const height = image.naturalHeight * scale;

		return (width);
	}


	captureButton.addEventListener('click', capturePhoto);

	function capturePhoto() {

		if (!selectedFile)
			return ;

		const file = fileInput.files[0];

		const formData = new FormData();
		formData.append('fileInput', file);

		// const rect = image.getBoundingClientRect();

		const width = getImageWidth();

		formData.append('imageWidth', width);

		let stickers = [];

		document.querySelectorAll('.overlay-sticker').forEach(sticker => {
			stickers.push({
				src: sticker.src,
				x: sticker.dataset.x,
				y: sticker.dataset.y
			});
		});

		formData.append("stickers", JSON.stringify(stickers));

		fetch('/webcam/fileInput', {
			method: 'POST',
			body: formData
		})
		.then(() => updateGallery())
		// .then(response => response.text())
		// .then(data => {
		// 	console.log(data);
		// })
		// .catch(error => {
		// 	console.error(error);
		// });

	}

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

	let selectedSticker = 0;

	document.querySelectorAll('.sticker').forEach(sticker => {
		sticker.addEventListener('click', () => {

			if (selectedSticker > 50 || selectedFile == null)
					return ;

				selectedSticker++;

				captureButton.disabled = false;

				const img = document.createElement("img");
				img.src = sticker.src;
				img.className = "overlay-sticker";
				img.dataset.x = 0;
				img.dataset.y = 0;

				const imageRect = image.getBoundingClientRect();
				const containerRect = container.getBoundingClientRect();

				img.style.left = (imageRect.left - containerRect.left) + 'px';
    			img.style.top = (imageRect.top - containerRect.top) + 'px';

				container.appendChild(img);
			});
		});

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
