<h1>SingIn</h1>
<form id="signUpForm" action="<?= BASE_URL ?>register" method="POST" novalidate>
	
	<label for="pseudo">Pseudo :</label>
	<input type="text" name="pseudo" id="pseudo" value="<?= $_SESSION['old']['pseudo'] ?? '' ?>" required>
		<?php if (!empty($_SESSION['errors']['pseudo'])) : ?>
			<div class="error"><?= $_SESSION['error']['pseudo'] ?></div>
		<?php endif; ?>

	<label for="email">Email :</label>
	<input type="email" name="email" id="email" value="<?= $_SESSION['old']['email'] ?? '' ?>" required>
		<?php if (!empty($_SESSION['errors']['email'])) : ?>
			<div class="error"><?= $_SESSION['error']['email'] ?></div>
		<?php endif; ?>

	<label for="confirm_password">Password :</label>
	<input type="password" name="password" id="password" value="<?= $_SESSION['old']['password'] ?? '' ?>" required>
		<?php if (!empty($_SESSION['errors']['password'])) : ?>
			<div class="error"><?= $_SESSION['error']['password'] ?></div>
		<?php endif; ?>

	
	<label for="confirm_password">Confirm Password :</label>
	<input type="password" name="confirm_password" id="confirm_password" value="<?= $_SESSION['old']['confirm_password'] ?? '' ?>" required>
		<?php if (!empty($_SESSION['errors']['confirm_password'])) : ?>
			<div class="error"><?= $_SESSION['error']['confirm_password'] ?></div>
		<?php endif; ?>

	<button type="submit">SingIn</button>
</form>
