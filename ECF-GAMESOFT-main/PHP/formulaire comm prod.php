<?php
// Configuration de la base de données
$servername = "localhost"; // Nom du serveur de base de données
$db_username = "root"; // Nom d'utilisateur MySQL
$db_password = ""; // Mot de passe MySQL
$dbname = "tableau jeu"; // Nom de la base de données

// Connexion à la base de données
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Vérification de la connexion à la base de données
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Traitement du formulaire de création de compte
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $accountType = $_POST["accountType"];

    // Validation des données (vous pouvez ajouter plus de règles de validation personnalisées ici)

    // Vérification si le nom d'utilisateur existe déjà dans la nouvelle table
    $stmt = $conn->prepare("SELECT username FROM producteurs_managers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nom d'utilisateur déjà utilisé, renvoyer une réponse d'erreur
        sendResponse(false, "Ce nom d'utilisateur est déjà utilisé.");
    } else {
        // Le nom d'utilisateur est unique, créer le compte dans la nouvelle table
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO producteurs_managers (username, password, account_type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $accountType);

        if ($stmt->execute()) {
            // Compte créé avec succès
            sendResponse(true, "Compte créé avec succès.");
        } else {
            // Erreur lors de l'exécution de la requête
            sendResponse(false, "Erreur lors de l'exécution de la requête : " . mysqli_error($conn));
        }
    }
}

// Fermeture de la connexion à la base de données
$conn->close();

// Fonction pour envoyer une réponse JSON
function sendResponse($success, $message) {
    $response = array("success" => $success, "message" => $message);
    header("Content-Type: application/json");
    echo json_encode($response);
    exit();
}
?>

