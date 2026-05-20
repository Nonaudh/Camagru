<h1><?= $desc ?? "" ?></h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<p class="message <?= !empty($error) ? 'error' : '' ?> <?= !empty($success) ? 'success' : '' ?>">
	<?= htmlspecialchars($error ?? $success ?? '') ?>
</p>

<form method="post" action="<?= BASE_URL ?>forgot" id="forgot_form">
	<label for="email">Your Email :</label>
	<input type="email" name="email" id="email" required>
	<button type="submit" id="submit_forgot">Reset</button>
</form>
