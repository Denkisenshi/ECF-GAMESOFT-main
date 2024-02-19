// Sélectionnez le formulaire
const gameForm = document.getElementById("game-form");

// Ajoutez un gestionnaire d'événements au formulaire pour l'envoi
gameForm.addEventListener("submit", function (e) {
    e.preventDefault(); // Empêche le formulaire de se soumettre normalement

    // Récupérez les données du formulaire
    const formData = new FormData(gameForm);

    // Envoyez les données du formulaire au script PHP via une requête AJAX
    fetch("admin.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Traitez la réponse du serveur ici, par exemple, mettez à jour l'interface utilisateur
        alert(data); // Affichez la réponse du serveur dans une alerte
    })
    .catch(error => {
        console.error("Erreur lors de l'ajout du jeu : " + error);
    });
});
