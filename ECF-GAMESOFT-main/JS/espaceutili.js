document.addEventListener("DOMContentLoaded", function () {
    // Sélectionnez les éléments du DOM
    const statutFilter = document.getElementById("filtre");
    const jeuxTableBody = document.querySelector("#jeux-table tbody");

    // Fonction pour charger et afficher les jeux favoris de l'utilisateur
    function chargerJeuxFavoris() {
        // Simulez des données de jeux favoris (remplacez par vos données réelles)
        const jeuxFavoris = [
            { titre: "Jeu 1", statut: "En cours" },
            { titre: "Jeu 2", statut: "Terminé" },
            { titre: "Jeu 3", statut: "En cours" },
        ];

        // Nettoyez le contenu du tableau
        jeuxTableBody.innerHTML = "";

        // Filtrage des jeux favoris en fonction du statut sélectionné
        const statutFiltre = statutFilter.value;
        const jeuxFiltres = statutFiltre === "Tous" ? jeuxFavoris : jeuxFavoris.filter(jeu => jeu.statut === statutFiltre);

        // Remplissez le tableau avec les jeux favoris filtrés
        jeuxFiltres.forEach(jeu => {
            const row = document.createElement("tr");
            const titreCell = document.createElement("td");
            const statutCell = document.createElement("td");

            titreCell.textContent = jeu.titre;
            statutCell.textContent = jeu.statut;

            row.appendChild(titreCell);
            row.appendChild(statutCell);

            jeuxTableBody.appendChild(row);
        });
    }

    // Ajoutez un gestionnaire d'événements au changement de filtre de statut
    statutFilter.addEventListener("change", chargerJeuxFavoris);

    // Chargez les jeux favoris lors du chargement de la page
    chargerJeuxFavoris();
});
