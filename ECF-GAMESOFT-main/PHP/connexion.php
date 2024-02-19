<?php
// Configuration de la base de données
$servername = "localhost"; // Nom du serveur de base de données
$db_username = "root"; // Nom d'utilisateur MySQL
$db_password = ""; // Mot de passe MySQL
$dbname = "tableau_jeu"; // Nom de la base de données

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("La connexion à la base de données a échoué : " . $e->getMessage());
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validation des données (vérifiez également la longueur, les caractères spéciaux, etc.)
    if (empty($username) || empty($password)) {
        sendResponse(false, "Nom d'utilisateur et mot de passe requis.");
    } else {
        // Préparation et exécution de la requête de vérification de la connexion
        $stmt = $pdo->prepare("SELECT username, password FROM utilisateurs WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $hashed_password = $row["password"];

            if (password_verify($password, $hashed_password)) {
                // Connexion réussie
                sendResponse(true, "Connexion réussie!");
            }
        }

        // Connexion échouée
        sendResponse(false, "Nom d'utilisateur ou mot de passe incorrect.");
    }
}

// Fonction pour envoyer une réponse JSON
function sendResponse($success, $message) {
    $response = array("success" => $success, "message" => $message);
    header("Content-Type: application/json");
    echo json_encode($response);
    exit();
}
?>
