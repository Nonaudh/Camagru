document.addEventListener('DOMContentLoaded', function() {

	function clearErrors()
	{
		document.querySelectorAll('.error-message').forEach(error => error.remove);_
	}

	document.getElementById('signUpForm').addEventListener('submit', function(e) {

		clearErrors();

		let formIsValid = true;

		document.querySelectorAll('.error').forEach(error => error.remove());

		const pseudo = document.getElementById('pseudo');
		const email = document.getElementById('email');
		const password = document.getElementById('password');
		const confirm_password = document.getElementById('confirm_password');

		if (pseudo.value.trim().length < 4)
		{
			showError(pseudo, "Pseudo need to have at least 4 caracters.");
			formIsValid = false;
		}

		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		if (!emailRegex.test(email.value.trim()))
		{
			showError(email, "Invalid email adress.");
			formIsValid = false;
		}

		const passwordValue = password.value;
		const confirmValue = confirm_password.value;
		const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

		if (!passwordRegex.test(passwordValue))
		{
			showError(password, "Password need to have at least 8 caracters, an uppercase letter and a number.");
			formIsValid = false;
		}

		if (!formIsValid)
			e.preventDefault();
	});

	function showError(input, message)
	{
		let errorElement = input.nextElementSibling;
		if (!errorElement || !errorElement.classList.contains('error-message'))
		{
			errorElement = document.createElement('div');
			errorElement.classList.add('error-message');
			errorElement.style.color = 'red';
			errorElement.style.fontSize = '0.9em';
			input.parentNode.insertBefore(errorElement, input.nextSibling);
		}
		errorElement.textContent = message;
	}
});
