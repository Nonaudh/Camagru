const LoadButton = document.getElementById('load-pictures-btn');

LoadButton.addEventListener('click', loadGallery);

let last_id = 100; //for test
let loading = false;
let hasMore = true;

function loadGallery() {

	if (loading || !hasMore)
        return;

	loading = true;

	fetch(`/gallery?last_id=${last_id}`)
	.then(response => response.json())
	.then(data => {
		appendPhotosToGallery(data.images);
		hasMore = data.hasMore;
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
        const card = document.createElement("div");
        card.className = "photo-card";

        card.innerHTML = `
            <img src="${photo.filepath}" alt="Photo ${photo.id}">
        `;
        gallery.appendChild(card);
    });
}
