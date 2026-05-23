<h1>Welcome to Webcam</h1>
<p>Hi <?= htmlspecialchars($_SESSION['user']['pseudo']) ?> !</p>

<form id="fileInput" action="<?= BASE_URL ?>webcam/fileInput" method="post" enctype="multipart/form-data">
	<label for="fileInput">Select a file:</label>
	<input type="file" id="fileInput" name="fileInput" required>

	<button type="submit">Submit File</button>
</form>
