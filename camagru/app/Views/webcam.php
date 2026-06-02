<h1>Welcome to Webcam</h1>
<p>Hi <?= htmlspecialchars($_SESSION['user']['pseudo']) ?> !</p>

<?php phpinfo(); ?>

<div class="camera-container">
    <video id="video" autoplay></video>
    <canvas id="canvas" hidden></canvas>

	<img id="previewSticker"
        class="overlay-sticker"
        src=""
        hidden
    >

</div>

<div id="stickers">
	<img class="sticker" src="/assets/stickers/crash.png">
</div>

<div class="buttons">
	<button id="capture-btn">
		Take Photo
	</button>

	<button id="save-btn" style="display:none;">
		Save
	</button>

	<button id="retake-btn" style="display:none;">
		Retake
	</button>
</div>

<script src="<?= BASE_URL ?>assets/js/webcam.js"></script>