<h1>SingIn</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<form id="signUpForm" action="<?= BASE_URL ?>register" method="POST" novalidate>
	
	<label for="pseudo">Pseudo :</label>
	<input type="text" name="pseudo" id="pseudo" value="<?= $_SESSION['old']['pseudo'] ?? '' ?>" required>

	<label for="email">Email :</label>
	<input type="email" name="email" id="email" value="<?= $_SESSION['old']['email'] ?? '' ?>" required>

	<label for="password">Password :</label>
	<input type="password" name="password" id="password" value="<?= $_SESSION['old']['password'] ?? '' ?>" required>

	<label for="confirm_password">Confirm Password :</label>
	<input type="password" name="confirm_password" id="confirm_password" value="<?= $_SESSION['old']['confirm_password'] ?? '' ?>" required>

	<button type="submit">SingIn</button>
</form>
