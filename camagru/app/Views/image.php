<h1>page image.php</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<div class="image-details">
	<?= '<img src= "' . htmlspecialchars($image['filepath']) . '">'; ?>
</div>

<div class="image-likes">
	<form method="POST" action="<?= BASE_URL ?>like" id="like_image">
		<input type="hidden" name="image_id" value="<?= htmlspecialchars($image['id']) ?>">
		<button type="submit" <?= isset($_SESSION['user']) && $_SESSION['user']['is_active'] ? '' : 'disabled' ?>> <?= $user_has_liked ? 'Un' : '' ?>Like</button>
	</form>

	<?= '<p> ' . htmlspecialchars($NumberOflikes) . ' </p>' ?>

</div>

<div class="comments">
	<?php if (isset($_SESSION['user']) && $_SESSION['user']['is_active']) : ?>
		<form method="POST" action="<?= BASE_URL ?>comment" id="post_comment">
			<input type="hidden" name="image_id" value="<?= htmlspecialchars($image['id']) ?>">
			<textarea name="comment" required></textarea>
			<button type="submit">Post comment</button>
		</form>
	<?php endif; ?>

	<?php foreach ($comments as $comment)
	{
		echo '<div class="single-comment">';
		echo '<p> ' . htmlspecialchars($comment['pseudo']) . '  ' . htmlspecialchars($comment['created_at']) . ' </p>';
		echo '<p> ' . htmlspecialchars($comment['content']) . ' </p>';
		echo '</div>';
	}
	?>
</div>
