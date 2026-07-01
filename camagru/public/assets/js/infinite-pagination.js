document.addEventListener("DOMContentLoaded", () => {

	const observer = new IntersectionObserver(entries => {
		if (entries[0].isIntersecting)
			loadGallery()
	});

	observer.observe(document.getElementById("home-observer"));

	let last_id = null;
	let loading = false;
	let has_more = true;

	function loadGallery() {

		if (loading || !has_more)
			return;

		loading = true;

		let url = '/gallery';

		if (last_id !== null)
			url += `?last_id=${last_id}`;

		fetch(url)
		.then(response => response.json())
		// .then(response => response.text())
		// .then(text => {
		//     console.log(text);
		// });
		.then(data => {
			appendPhotosToGallery(data.images);
			has_more = data.has_more;
			last_id = data.last_id;
		})
		.catch(err => {
			console.error('Gallery load error:', err);
		})
		.finally(() => {
			loading = false;
		}); 
	}

	function appendPhotosToGallery(photos) {
		const gallery = document.getElementById("home-gallery");

		photos.forEach(photo => {

			const link = document.createElement("a");
			link.href = `image?id=${photo.id}`;

			const img = document.createElement("img");
			img.src = photo.filepath;

			link.appendChild(img);
			gallery.appendChild(link);
		});
	}
});
