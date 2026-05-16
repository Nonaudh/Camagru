<h1>Login</h1>

<?php if (!empty($errors)) : ?>
	<div style="color:red;">
		<?php foreach ($errors as $err) : ?>
			<p><?= htmlspecialchars($err) ?></p>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<form id="login-form" action="<?= BASE_URL ?>login/post" method="post">

	<label for="email">Email :</label><br>
	<input type="email" name="email" id="email" required>
	<div id="email-error" class="error-message"></div>

	<label for="password">Password :</label><br>
	<input type="password" name="password" id="password" required>
	<div id="password-error" class="error-message"></div>

	<button type="submit">Login</button>
</form>
<script src="<?= BASE_URL ?>assets/js/login-form-validation.js" defer></script>

<p>Not registered yet ? <a href="<?= BASE_URL ?>signin">Create an account</a></p>
