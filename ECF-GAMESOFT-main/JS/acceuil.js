document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const message = document.getElementById("message");

    // Vérifiez si l'utilisateur est connecté en vérifiant un cookie
    if (getCookie("userLoggedIn") === "true") {
        // Si connecté, affichez le lien de déconnexion et masquez le lien de connexion
        document.getElementById("connexion-link").style.display = "none";
        document.getElementById("deconnexion-link").style.display = "block";
    }

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
                        // Redirigez l'utilisateur vers la page spécifiée dans le champ "redirect"
                        window.location.href = response.redirect;

                        // Définissez un cookie pour indiquer que l'utilisateur est connecté
                        setCookie("userLoggedIn", "true", 1); // Le cookie expire dans 1 jour (ajustez selon vos besoins)
                        
                        // Masquez le lien de connexion et affichez le lien de déconnexion
                        document.getElementById("connexion-link").style.display = "none";
                        document.getElementById("deconnexion-link").style.display = "block";
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

    // Fonction pour définir un cookie
    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + "; " + expires;
    }

    // Fonction pour obtenir la valeur d'un cookie
    function getCookie(name) {
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim();
            if (cookie.indexOf(name + "=") === 0) {
                return cookie.substring(name.length + 1, cookie.length);
            }
        }
        return "";
    }
});
