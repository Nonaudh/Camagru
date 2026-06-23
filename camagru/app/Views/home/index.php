<h1>page index.php</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>


<div class="pictures-container" id="home-gallery">

	<!-- <?php foreach ($images as $image)
	{
		echo '<a href= "image?id=' . htmlspecialchars($image['id']) .'">';
		echo '<img src= "' . htmlspecialchars($image['filepath']) . '">';
		echo '</a>';
	}
	?> -->

</div>

<div id="home-observer"></div>

<script src="<?= BASE_URL ?>assets/js/infinite-pagination.js"></script>
