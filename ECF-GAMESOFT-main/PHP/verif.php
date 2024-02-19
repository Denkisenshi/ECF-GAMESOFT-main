<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION["userLoggedIn"]) && $_SESSION["userLoggedIn"] === true) {
    // L'utilisateur est connecté
    echo json_encode(array("loggedIn" => true));
} else {
    // L'utilisateur n'est pas connecté
    echo json_encode(array("loggedIn" => false));
}
?>

