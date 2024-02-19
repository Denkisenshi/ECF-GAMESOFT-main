document.addEventListener("DOMContentLoaded", function () {
    // Sélectionnez les éléments du DOM
    const budgetForm = document.getElementById("budget-form");
    const statutFilter = document.getElementById("statut-filter");
    const jeuxTableBody = document.querySelector("#jeux-table tbody");

    // Fonction pour charger et afficher les données des jeux vidéo
    function chargerDonneesJeux() {
        fetch("espaceprod.php")
            .then(response => response.json()) // Traitement JSON ici
            .then(data => {
                // Nettoyez le contenu du tableau
                jeuxTableBody.innerHTML = "";

                // Filtrage des données en fonction du statut sélectionné
                const statutFiltre = statutFilter.value;
                const jeuxFiltres = statutFiltre === "Tous" ? data : data.filter(jeu => jeu.statut === statutFiltre);

                // Remplissez le tableau avec les données filtrées
                jeuxFiltres.forEach(jeu => {
                    const row = document.createElement("tr");
                    const titreCell = document.createElement("td");
                    const budgetCell = document.createElement("td");

                    titreCell.textContent = jeu.titre;
                    budgetCell.textContent = jeu.budget;

                    row.appendChild(titreCell);
                    row.appendChild(budgetCell);

                    jeuxTableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error("Erreur lors du chargement des données : " + error);
            });
    }

    // Ajoutez un gestionnaire d'événements au formulaire de modification du budget
    budgetForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Empêche le formulaire de se soumettre normalement

        // Récupérez les données du formulaire
        const formData = new FormData(budgetForm);

        // Envoyez les données du formulaire au serveur via une requête AJAX
        fetch("espaceprod.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Affichez la réponse du serveur dans une alerte
            // Actualisez la vue globale des jeux vidéo après la modification
            chargerDonneesJeux();
        })
        .catch(error => {
            console.error("Erreur lors de la modification : " + error);
        });
    });

    // Ajoutez un gestionnaire d'événements au changement de filtre de statut
    statutFilter.addEventListener("change", chargerDonneesJeux);

    // Chargez les données des jeux vidéo lors du chargement de la page
    chargerDonneesJeux();
});











// Sélectionnez le formulaire
const budgetForm = document.getElementById("budget-form");

// Ajoutez un gestionnaire d'événements au formulaire pour l'envoi
budgetForm.addEventListener("submit", function (e) {
    e.preventDefault(); // Empêche le formulaire de se soumettre normalement

    // Récupérez les données du formulaire
    const formData = new FormData(budgetForm);

    // Envoyez les données du formulaire au script PHP via une requête AJAX
    fetch("espaceprod.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Traitez la réponse du serveur ici, par exemple, mettez à jour l'interface utilisateur
        alert("Modification réussie !");
    })
    .catch(error => {
        console.error("Erreur lors de la modification : " + error);
    });
});


