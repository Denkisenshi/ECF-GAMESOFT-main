<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] === true) {
    // Utilisateur connecté
    echo json_encode(["logged_in" => true]);
} else {
    // Utilisateur non connecté
    echo json_encode(["logged_in" => false]);
}
?>

