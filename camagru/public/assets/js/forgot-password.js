document.addEventListener("DOMContentLoaded", () => {
	const form = document.getElementById("forgot_form");
	const emailInput = document.getElementById("email");
	const submitForm = document.getElementById("submit_forgot");

	const errorMsg = document.createElement("p");
	errorMsg.style.color = "red";
	errorMsg.style.fontSize = "0.9em";
	errorMsg.style.marginTop = "5px";
	errorMsg.style.display = "none";
	emailInput.insertAdjacentElement("afterend", errorMsg);

	const isValidEmail = (email) => {
		const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		return (regex.test(email));
	};

	form.addEventListener("submit", (e) => {
		const email = emailInput.value.trim();

		if (!isValidEmail(email)) {
			e.preventDefault();
			errorMsg.textContent = "Please enter a valie e-mail.";
			errorMsg.style.display = "block";
		}
		else
			errorMsg.style.display = "none";
	});
});
