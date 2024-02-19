<?php
<?php
// Configuration de la base de données
$servername = "localhost"; // Nom du serveur de base de données
$db_username = "root"; // Nom d'utilisateur MySQL
$db_password = ""; // Mot de passe MySQL
$dbname = "tableau_jeu"; // Nom de la base de données

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur lors de la connexion à la base de données, affichez le message d'erreur
    sendResponse(false, "La connexion à la base de données a échoué : " . $e->getMessage());
}

// Vérifiez si le paramètre 'token' est présent dans l'URL
if (isset($_GET["token"])) {
    $token = $_GET["token"];

    // Recherchez l'utilisateur avec ce jeton dans la base de données
    $stmt = $pdo->prepare("SELECT email_verified FROM utilisateurs WHERE verification_token = ?");
    $stmt->execute([$token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Vérifiez si l'adresse e-mail a déjà été vérifiée
        if ($row["email_verified"] == 1) {
            sendResponse(false, "L'adresse e-mail a déjà été vérifiée.");
        } else {
            // Marquez l'adresse e-mail de l'utilisateur comme vérifiée
            $stmt = $pdo->prepare("UPDATE utilisateurs SET email_verified = 1 WHERE verification_token = ?");
            $stmt->execute([$token]);
            sendResponse(true, "Adresse e-mail vérifiée avec succès.");
        }
    } else {
        sendResponse(false, "La vérification de l'adresse e-mail a échoué.");
    }
} else {
    sendResponse(false, "Paramètre 'token' manquant dans l'URL.");
}

// Fonction pour envoyer une réponse JSON
function sendResponse($success, $message) {
    $response = array("success" => $success, "message" => $message);
    header("Content-Type: application/json");
    echo json_encode($response);
    exit();
}
?>




