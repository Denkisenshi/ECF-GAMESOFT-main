document.addEventListener("DOMContentLoaded", function() {
    const createAccountForm = document.getElementById("createAccountForm");

    createAccountForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const accountType = document.getElementById("accountType").value;

        // Envoyer les données au serveur pour la création du compte
        createUserAccount(username, password, accountType);
    });

    function createUserAccount(username, password, accountType) {
        // Effectuer une requête AJAX pour créer le compte sur le serveur
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "formulaire comm prod.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);

                        if (response.success) {
                            alert("Compte créé avec succès !");
                            // Réinitialiser le formulaire ou rediriger vers une autre page
                        } else {
                            alert("Erreur lors de la création du compte : " + response.message);
                        }
                    } catch (e) {
                        alert("Réponse invalide du serveur.");
                    }
                } else {
                    alert("Erreur de connexion au serveur.");
                }
            }
        };

        const data = `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}&accountType=${encodeURIComponent(accountType)}`;
        xhr.send(data);
    }
});
