document.addEventListener('DOMContentLoaded', function () {
	const form = document.querySelector('#login-form');
	const emailInput = document.querySelector('#email');
	const passwordInput = document.querySelector('#password');

	const emailError = document.querySelector('#email-error');
	const passwordError = document.querySelector('#password-error');

	form.addEventListener('submit', function(e) {
		let isValid = true;

		emailError.textContent = '';
		passwordError.textContent = '';

		const emailValue = emailInput.value.trim();
		const passwordValue = passwordInput.value;

		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (!emailRegex.test(emailValue))
		{
			emailError.textContent = 'Invalid e-mail adress';
			isValid = false;
		}

		// password regex ?
		if (passwordValue === '')
		{
			passwordError.textContent = 'Enter a password';
			isValid = false;
		}

		if (!isValid)
			e.preventDefault();
	});
});
