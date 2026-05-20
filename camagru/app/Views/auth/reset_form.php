<h1>Reset your Password</h1>

<div>
	<p class="message error">
		<?= !empty($error) ? htmlspecialchars($error) : '' ?>
	</p>
	<p class="message success">
		<?= !empty($success) ? htmlspecialchars($success) : '' ?>
	</p>
</div>

<form method="post" action="<?= BASE_URL ?>updatePassword" id="reset_form">
	<input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

	<label for="password">New Password :</label>
	<input type="password" id="password" name="password" required>

	<label for="confirm">Confirm your Password :</label>
	<input type="password" id="confirm" name="confirm" required>

	<button type="submit">Reset Password</button>
</form>
<!-- <script src="<?= BASE_URL ?>assets/js/reset-password-validation.js"></script> -->
