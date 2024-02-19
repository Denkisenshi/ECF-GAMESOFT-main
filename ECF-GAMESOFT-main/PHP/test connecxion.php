<?php
// Inclure le fichier de connexion PDO
require 'connexion.php';

// Vérifier si les données POST ont été envoyées
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si les champs username et password existent dans $_POST
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Récupérer les données POST
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            // Préparer la requête SQL pour récupérer les informations de l'utilisateur
            $sql = "SELECT * FROM utilisateurs WHERE username = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username]);

            // Vérifier si l'utilisateur existe dans la base de données
            if ($stmt->rowCount() == 1) {
                // Récupérer la ligne de résultat
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Vérifier si le mot de passe correspond
                if (password_verify($password, $user['password'])) {
                    // Le mot de passe est correct, connexion réussie
                    echo "Connexion réussie pour l'utilisateur : " . $user['username'];
                } else {
                    // Le mot de passe est incorrect
                    echo "Mot de passe incorrect.";
                }
            } else {
                // Aucun utilisateur trouvé avec ce nom d'utilisateur
                echo "Nom d'utilisateur incorrect.";
            }
        } catch (PDOException $e) {
            // Erreur lors de l'exécution de la requête SQL
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        // Les champs username et password n'ont pas été envoyés avec la requête POST
        echo "Veuillez fournir un nom d'utilisateur et un mot de passe.";
    }
}

// Fermeture de la connexion à la base de données
$pdo = null;
?>


