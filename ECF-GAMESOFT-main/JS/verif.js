document.addEventListener("DOMContentLoaded", function() {
    const connexionLink = document.getElementById("connexion-link");
    const deconnexionLink = document.getElementById("deconnexion-link");

    // Effectuer une requête AJAX vers verif.php pour vérifier l'état de connexion
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "verif.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const utilisateurConnecte = response.utilisateurConnecte;

                if (utilisateurConnecte) {
                    connexionLink.style.display = "none";
                    deconnexionLink.style.display = "block";
                } else {
                    connexionLink.style.display = "block";
                    deconnexionLink.style.display = "none";
                }
            }
        }
    };

    xhr.send();
});
