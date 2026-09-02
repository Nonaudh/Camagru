<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>


<div class="pictures-container" id="home-gallery"></div>

<div id="home-observer"></div>

<script src="<?= BASE_URL ?>assets/js/infinite-pagination.js"></script>
