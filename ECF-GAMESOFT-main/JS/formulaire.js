document.addEventListener("DOMContentLoaded", function() {
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");
    const passwordError = document.getElementById("password-error");
    const successMessage = document.getElementById("success-message");
    const formulaire = document.querySelector("form");

    passwordInput.addEventListener("input", validatePassword);
    confirmPasswordInput.addEventListener("input", validateConfirmPassword);

    function validatePassword() {
        const password = passwordInput.value;
        const passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

        if (!passwordPattern.test(password)) {
            passwordError.textContent = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.";
            passwordInput.setCustomValidity("Le mot de passe ne respecte pas les critères.");
        } else {
            passwordError.textContent = "";
            passwordInput.setCustomValidity("");
        }
    }

    function validateConfirmPassword() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (password !== confirmPassword) {
            confirmPasswordInput.setCustomValidity("Les mots de passe ne correspondent pas.");
        } else {
            confirmPasswordInput.setCustomValidity("");
        }
    }

    formulaire.addEventListener("submit", function(event) {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (!passwordPattern.test(password) || password !== confirmPassword) {
            event.preventDefault(); // Empêche la soumission du formulaire si la validation échoue
        }
    });
});


