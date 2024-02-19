// Fonction pour mettre à jour la section "fil d'actualités"
function mettreAJourFilActualites() {
    const filActualites = document.getElementById("fil-actualites");

    // Effectuer une requête AJAX pour récupérer les actualités depuis le serveur
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "actualite.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Actualisez le contenu du fil d'actualités avec les données reçues
                filActualites.innerHTML = xhr.responseText;
            } else {
                // Gérer les erreurs de la requête AJAX ici
                console.error("Erreur lors de la récupération des actualités.");
            }
        }
    };

    xhr.send();
}

// Actualisez le fil d'actualités toutes les 15 secondes (ajustez selon vos besoins)
setInterval(mettreAJourFilActualites, 15000);

// Appelez la fonction pour mettre à jour le fil d'actualités au chargement de la page
mettreAJourFilActualites();
