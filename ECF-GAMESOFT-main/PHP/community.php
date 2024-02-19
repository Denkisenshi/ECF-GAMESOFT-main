<?php
header("Content-Type: application/json");

// Connexion à la base de données (veuillez remplacer les valeurs par les vôtres)
$host = 'localhost';
$dbname = 'tableau_jeu';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $response = ["success" => false, "error" => "Erreur de connexion à la base de données : " . $e->getMessage()];
    echo json_encode($response);
    exit();
}

// Récupérez les données du formulaire
$titre = $_POST["titre"];
$contenu = $_POST["contenu"];

// SQL pour insérer une nouvelle dans la base de données 
$sql = "INSERT INTO actualites (titre, contenu, date_publication) VALUES (:titre, :contenu, NOW())";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
    $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
    $stmt->execute();
    $response = ["success" => true];
} catch (PDOException $e) {
    $response = ["success" => false, "error" => "Erreur lors de l'insertion de la nouvelle : " . $e->getMessage()];
}

echo json_encode($response);
?>

