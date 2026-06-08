<h1>Welcome to Webcam</h1>
<p>Hi <?= htmlspecialchars($_SESSION['user']['pseudo']) ?> !</p>

<form id="fileInput" action="<?= BASE_URL ?>webcam/fileInput" method="post" enctype="multipart/form-data">
	<label for="fileInput">Select a file:</label>
	<input type="file" id="fileInput" name="fileInput" required>

	<button type="submit">Submit File</button>
</form>

<div class="camera-container">
    <video id="video" autoplay></video>
    <canvas id="canvas" hidden></canvas>

	<img id="previewSticker" class="overlay-sticker" src="" hidden>
</div>

<div id="stickers">
	<img class="sticker" src="/assets/stickers/crash.png">
</div>

<button type="button" id="capture-btn">Take Photo</button>

<script src="<?= BASE_URL ?>assets/js/webcam.js"></script>
<script src="<?= BASE_URL ?>assets/js/drag-stickers.js"></script>