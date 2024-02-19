document.addEventListener("DOMContentLoaded", function() {
    // Obtenez le jeton de vérification à partir de l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const token = urlParams.get("token");

    // Sélectionnez l'élément où vous afficherez le message
    const messageElement = document.getElementById("message");

    // Si le jeton est présent dans l'URL, envoyez une requête de vérification au serveur
    if (token) {
        fetch("verification.php?token=" + token)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // La vérification a réussi
                    messageElement.textContent = "Votre adresse e-mail a été vérifiée avec succès. Vous pouvez maintenant vous connecter.";
                } else {
                    // La vérification a échoué
                    messageElement.textContent = "La vérification de l'adresse e-mail a échoué. Veuillez contacter le support.";
                }
            })
            .catch(error => {
                // Gestion des erreurs de la requête fetch
                console.error("Erreur lors de la vérification : ", error);
                messageElement.textContent = "Une erreur s'est produite lors de la vérification. Veuillez réessayer plus tard.";
            });
    } else {
        // Le jeton est manquant dans l'URL
        messageElement.textContent = "Jeton de vérification manquant.";
    }
});

