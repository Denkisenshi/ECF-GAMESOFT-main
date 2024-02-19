<?php
session_start();
// Déconnexion de la session
$_SESSION = array(); // Vide les variables de session

// Destruction complète de la session
session_destroy();

// Redirection vers la page de connexion
header("Location: connexion.html");
exit(); // Assure que le script se termine après la redirection
?>
