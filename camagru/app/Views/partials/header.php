<header>
	<h1><a href="<?= BASE_URL ?>">Camagraou</a></h1>
	<nav>
		<?php if (isset($_SESSION['user'])) : ?>
			<a href="<?= BASE_URL ?>webcam">Webcam</a>
			<a href="<?= BASE_URL ?>profile">Profile</a>
			<a href="<?= BASE_URL ?>logout">Logout</a>
		<?php else: ?>
			<a href="<?= BASE_URL ?>signin">SignIn</a>
			<a href="<?= BASE_URL ?>login">Login</a>
		<?php endif; ?>
	</nav>
</header>
