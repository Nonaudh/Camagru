<h1>Profile</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<form id="ProfileForm" action="<?= BASE_URL ?>profile/post" method="POST">
	
	<label for="new_pseudo">New Pseudo :</label>
	<input type="text" name="new_pseudo" id="new_pseudo" value="<?= $_SESSION['old']['new_pseudo'] ?? '' ?>">

	<label for="new_email">New Email :</label>
	<input type="email" name="new_email" id="new_email" value="<?= $_SESSION['old']['new_email'] ?? '' ?>">

	<label for="new_password">New Password :</label>
	<input type="password" name="new_password" id="new_password" value="<?= $_SESSION['old']['new_password'] ?? '' ?>">

	<label for="confirm_new_password">Confirm New Password :</label>
	<input type="password" name="confirm_new_password" id="confirm_new_password" value="<?= $_SESSION['old']['confirm_new_password'] ?? '' ?>">

	<button type="submit">Send modification</button>
</form>
