<h1>Profile</h1>

<p class="message <?= $flash['type'] ?? '' ?>">
	<?= !empty($flash) ? htmlspecialchars($flash['message']) : '' ?>
</p>

<form action="<?= BASE_URL ?>profile/post" method="POST">
	<label for="new_pseudo">New Pseudo :</label>
	<input type="text" name="new_pseudo" id="new_pseudo" value="<?= $_SESSION['old']['new_pseudo'] ?? '' ?>" required>
	<button type="submit">Send modification</button>
</form>

<form action="<?= BASE_URL ?>profile/post" method="POST">
	<label for="new_email">New Email :</label>
	<input type="email" name="new_email" id="new_email" value="<?= $_SESSION['old']['new_email'] ?? '' ?>" required>
	<button type="submit">Send modification</button>
</form>

<form action="<?= BASE_URL ?>profile/post" method="POST">
	<label for="new_password">New Password :</label>
	<input type="password" name="new_password" id="new_password" value="<?= $_SESSION['old']['new_password'] ?? '' ?>" required>
	<label for="confirm_new_password">Confirm New Password :</label>
	<input type="password" name="confirm_new_password" id="confirm_new_password" value="<?= $_SESSION['old']['confirm_new_password'] ?? '' ?>" required>
	<button type="submit">Send modification</button>
</form>

<form action="<?= BASE_URL ?>profile/post" method="POST">
	<input type="hidden" name="mail_notif" value=1>
	<button type="submit"><?= (isset($_SESSION['user']) && $_SESSION['user']['mail_notif']) ? 'disable ' : 'enable ' ?> mail notification</button>
</form>
