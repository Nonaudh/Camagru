<h1>Welcome to Webcam with file</h1>
<p>Hi <?= htmlspecialchars($_SESSION['user']['pseudo']) ?> !</p>

<p>Want to activate your webcam ? <a href="<?= BASE_URL ?>webcam?i=webcam">Click here</a></p>

<!-- <form id="uploadForm" action="<?= BASE_URL ?>webcam/fileInput" method="post" enctype="multipart/form-data">
	<label for="file">Select a file:</label>
	<input type="file" id="file" name="fileInput" required>

	<button type="submit">Submit File</button>
</form> -->

<input type="file" id="file" accept="image/png, image/jpeg">

<div id="webcam-container">
	<div id="camera-container">
		<canvas id="canvas" hidden></canvas>
		<img src="" id="image" alt="Preview">
	</div>

    <div id="thumbnails"></div>
</div>

<div id="stickers">
	<img class="sticker" src="/assets/stickers/wu-tang-logo.png">
	<img class="sticker" src="/assets/stickers/cdm.png">
	<img class="sticker" src="/assets/stickers/pat.png">
	<img class="sticker" src="/assets/stickers/cat.png">
</div>

<button type="button" id="capture-btn" disabled>Take Photo</button>

<script src="<?= BASE_URL ?>assets/js/webcamFile.js"></script>
<script src="<?= BASE_URL ?>assets/js/drag-stickers.js"></script>