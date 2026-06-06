<h1>page index.php</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<?php

foreach ($images as $image)
{
	echo '<img src= "' . htmlspecialchars($image['filepath']) . '">';
}

?>
