document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const message = document.getElementById("message");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();
        
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        // Effectuer une requête AJAX pour vérifier les informations de connexion
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "connexion.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    
                    if (response.success) {
                        // Connexion réussie
                        message.textContent = "Connexion réussie!";
                        message.style.color = "green";
                        // Redirigez l'utilisateur vers la page souhaitée (par exemple, tableau de bord)
                        window.location.href = "acceuil.html";
                    } else {
                        // Connexion échouée
                        message.textContent = "Nom d'utilisateur ou mot de passe incorrect.";
                        message.style.color = "red";
                    }
                } else {
                    // Gérer les erreurs de la requête AJAX ici
                    message.textContent = "Erreur de connexion.";
                    message.style.color = "red";
                }
            }
        };
        
        const data = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
        xhr.send(data);
    });
});




