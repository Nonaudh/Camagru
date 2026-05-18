<h1><?= $desc ?? "" ?></h1>

<?php $message = $message ?? ""; ?>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($message)) echo "<p style='color:green;'>$message</p>;" ?>

<?php if ($message != "Password reset mail was sent") : ?>
	<form method="post" action="<?= BASE_URL ?>forgot" id="forgot_form">
		<label for="email">Your Email :</label>
		<input type="email" name="email" id="email" required>
		<button type="submit" id="submit_forgot">Reset</button>
	</form>
	<script src="<?= BASE_URL ?>assets/js/forgot-password.js" defer></script>
<?php endif ; ?>
