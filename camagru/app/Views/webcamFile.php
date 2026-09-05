<h1>Welcome to Webcam with file</h1>
<p>Hi <?= htmlspecialchars($_SESSION['user']['pseudo']) ?> !</p>

<p>Want to take pics with your webcam ? <a href="<?= BASE_URL ?>webcam?i=webcam">Click here</a></p>

<input type="file" id="fileInput" accept="image/png, image/jpeg, image/jpg">

<div id="webcam-container">
	<div id="camera-container">
		<canvas id="canvas" hidden></canvas>
		<img src="" id="image">
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
<script src="<?= BASE_URL ?>assets/js/drag-stickersFile.js"></script>