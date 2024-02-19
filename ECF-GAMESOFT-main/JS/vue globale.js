document.addEventListener("DOMContentLoaded", function() {
    // ...

    // Écouteur d'événement pour le bouton "Appliquer les filtres"
    document.getElementById("appliquer-filtres").addEventListener("click", updateJeuxList);

    // Fonction pour mettre à jour la liste des jeux vidéo en fonction des filtres
    function updateJeuxList() {
        const statutFilter = document.getElementById("statut-filter").value;
        const dateFinFilter = document.getElementById("date-fin-filter").value;
        const titreFilter = document.getElementById("titre-filter").value;
        const typeFilter = document.getElementById("type-filter").value;

        // Effectuer une requête AJAX pour récupérer les jeux vidéo filtrés
        fetch("vue globale.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `statut=${statutFilter}&date_fin=${dateFinFilter}&titre=${titreFilter}&type=${typeFilter}`,
        })
            .then((response) => response.json())
            .then((data) => {
                const jeuxListElement = document.getElementById("jeux-list");
                jeuxListElement.innerHTML = ""; // Effacer la liste actuelle des jeux

                data.forEach((jeu) => {
                    const listItem = document.createElement("li");
                    const jeuLink = document.createElement("a");
                    jeuLink.href = `${jeu.nom}.html`;
                    jeuLink.textContent = jeu.nom;

                    const description = document.createElement("p");
                    description.textContent = jeu.description;

                    const score = document.createElement("span");
                    score.textContent = `Score : ${jeu.score}`;

                    listItem.appendChild(jeuLink);
                    listItem.appendChild(description);
                    listItem.appendChild(score);

                    jeuxListElement.appendChild(listItem);
                });
            })
            .catch((error) => {
                console.error("Erreur lors de la récupération des jeux vidéo :", error);
            });
    }

    // ...
});

// Écouteurs d'événements pour les filtres
document.getElementById("statut-filter").addEventListener("change", updateJeuxList);
document.getElementById("date-fin-filter").addEventListener("change", updateJeuxList);
document.getElementById("titre-filter").addEventListener("input", updateJeuxList);
document.getElementById("type-filter").addEventListener("change", updateJeuxList);

// Initialisation de la liste des jeux vidéo au chargement de la page
document.addEventListener("DOMContentLoaded", updateJeuxList);








