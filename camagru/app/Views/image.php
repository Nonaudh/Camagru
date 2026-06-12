<h1>page image.php</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<div class="image-details">
	<?= '<img src= "' . htmlspecialchars($image['filepath']) . '">'; ?>
</div>
