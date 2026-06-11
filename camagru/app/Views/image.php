<h1>page image.php</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<?= '<img src= "' . htmlspecialchars($image['filepath']) . '">'; ?>

