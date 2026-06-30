<h1>Login</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<form id="login-form" action="<?= BASE_URL ?>login/post" method="post">

	<label for="pseudo">Pseudo :</label>
	<input type="pseudo" name="pseudo" id="pseudo" required>

	<label for="password">Password :</label>
	<input type="password" name="password" id="password" required>

	<button type="submit">Login</button>
</form>

<p><a href="<?= BASE_URL ?>forgot">Forgot your password ?</a></p>
<p>Not registered yet ? <a href="<?= BASE_URL ?>signin">Create an account</a></p>
