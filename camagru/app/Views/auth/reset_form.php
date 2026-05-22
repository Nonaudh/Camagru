<h1>Reset your Password</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<form method="post" action="<?= BASE_URL ?>updatePassword" id="reset_form">
	<input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

	<label for="password">New Password :</label>
	<input type="password" id="password" name="password" required>

	<label for="confirm">Confirm your Password :</label>
	<input type="password" id="confirm" name="confirm" required>

	<button type="submit">Reset Password</button>
</form>
