<h1>Welcome to Webcam</h1>
<p>Hi <?= htmlspecialchars($_SESSION['user']['pseudo']) ?> !</p>

<form id="uploadForm" action="<?= BASE_URL ?>webcam/fileInput" method="post" enctype="multipart/form-data">
	<label for="file">Select a file:</label>
	<input type="file" id="file" name="fileInput" required>

	<button type="submit">Submit File</button>
</form>

<div id="webcam-container">
	<div id="camera-container">
		<video id="video" autoplay></video>
		<canvas id="canvas" hidden></canvas>

		<img id="previewSticker" class="overlay-sticker" src="" hidden>
	</div>

    <div id="thumbnails"></div>
</div>

<div id="stickers">
	<img class="sticker" src="/assets/stickers/crash.png">
	<img class="sticker" src="/assets/stickers/wu-tang-logo.png">
	<img class="sticker" src="/assets/stickers/cdm.png">
</div>

<button type="button" id="capture-btn">Take Photo</button>

<script src="<?= BASE_URL ?>assets/js/webcam.js"></script>
<script src="<?= BASE_URL ?>assets/js/drag-stickers.js"></script>