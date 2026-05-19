document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("reset_form");
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("confirm");

    // Création du conteneur d'erreur si besoin
    let errorContainer = document.createElement("div");
    errorContainer.id = "password-errors";
    errorContainer.style.color = "red";
    errorContainer.style.marginTop = "10px";
    form.appendChild(errorContainer);

    form.addEventListener("submit", function (e) {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        let errors = [];

        // Vérifications
        if (password !== confirm) {
            errors.push("Les mots de passe ne correspondent pas.");
        }

        if (password.length < 8) {
            errors.push("Le mot de passe doit contenir au moins 8 caractères.");
        }

        if (!/[A-Z]/.test(password)) {
            errors.push("Le mot de passe doit contenir au moins une lettre majuscule.");
        }

        if (!/[0-9]/.test(password)) {
            errors.push("Le mot de passe doit contenir au moins un chiffre.");
        }

        // Affichage et blocage du formulaire si erreurs
        if (errors.length > 0) {
            e.preventDefault();
            errorContainer.innerHTML = "";
            errors.forEach(function (err) {
                const p = document.createElement("p");
                p.textContent = err;
                errorContainer.appendChild(p);
            });
        }
    });
});
