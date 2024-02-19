document.addEventListener("DOMContentLoaded", function () {
    const publicationForm = document.getElementById("publication-form");

    publicationForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(publicationForm);

        // Envoyer les données au serveur via une requête POST (utilisez le script PHP pour gérer la publication)
        fetch("community.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Nouvelle publiée avec succès.");
                publicationForm.reset();
            } else {
                alert("Erreur lors de la publication de la nouvelle.");
            }
        })
        .catch(error => {
            console.error("Erreur lors de la publication : " + error);
        });
    });
});
