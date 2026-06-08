<h1>page index.php</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>


<div class="pictures-container">

	<?php foreach ($images as $image)
	{
		echo '<a target="_blank" href="' . str_replace('.jpeg', '', htmlspecialchars($image['filepath'])) . '">';
		echo '<img src= "' . htmlspecialchars($image['filepath']) . '">';
		echo '</a>';
	}
	?>

</div>
