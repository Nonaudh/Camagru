<h1>page image.php</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<div class="image-details">
	<?= '<img src= "' . htmlspecialchars($image['filepath']) . '">'; ?>
</div>

<div class="comments">
	<?php if (isset($_SESSION['user'])) : ?>
		<form method="POST" action="<?= BASE_URL ?>comment" id="post_comment">
			<input type="hidden" name="image_id" value="<?= htmlspecialchars($image['id']) ?>">
			<textarea name="comment" required></textarea>
			<button type="submit">Post comment</button>
		</form>
	<?php endif; ?>

	<?php foreach ($comments as $comment)
	{
		// comments.content, comments.created_at, users.pseudo

		echo '<div class="single-comment">';
		echo '<p> ' . htmlspecialchars($comment['pseudo']) . '  ' . htmlspecialchars($comment['created_at']) . ' </p>';
		echo '<p> ' . htmlspecialchars($comment['content']) . ' </p>';
		echo '</div>';
	}
	?>
</div>
