document.addEventListener("DOMContentLoaded", function() {
    const resetPasswordForm = document.getElementById("resetPasswordForm");
    const resetMessage = document.getElementById("resetMessage");

    resetPasswordForm.addEventListener("submit", function(event) {
        event.preventDefault();
        
        const email = document.getElementById("email").value;

        // Effectuer une requête AJAX pour réinitialiser le mot de passe
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "resetpassword.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                console.log(xhr.responseText);
                if (xhr.status === 200) {
                    // Vérifier si la réponse est du texte JSON valide
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        // Vérifier si la réponse contient les clés "success" et "message"
                        if ("success" in response && "message" in response) {
                            if (response.success) {
                                // Réinitialisation réussie
                                resetMessage.textContent = response.message;
                                resetMessage.style.color = "green";
                            } else {
                                // Réinitialisation échouée
                                resetMessage.textContent = response.message;
                                resetMessage.style.color = "red";
                            }
                        } else {
                            // Réponse JSON mal formatée
                            resetMessage.textContent = "Réponse JSON mal formatée. Veuillez réessayer.";
                            resetMessage.style.color = "red";
                        }
                    } catch (error) {
                        // Erreur lors de la conversion en JSON
                        resetMessage.textContent = "Erreur lors de la conversion de la réponse en JSON. Veuillez réessayer.";
                        resetMessage.style.color = "red";
                    }
                } else {
                    // Gérer les erreurs de la requête AJAX ici
                    resetMessage.textContent = "Erreur lors de la réinitialisation du mot de passe. Veuillez réessayer.";
                    resetMessage.style.color = "red";
                }
            }
        };
        
        const data = "email=" + encodeURIComponent(email);
        xhr.send(data);
    });
});
