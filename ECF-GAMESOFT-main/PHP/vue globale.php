<?php
// Connexion à la base de données avec PDO
try {
    $pdo = new PDO('mysql:host=localhost;dbname=tableau jeu;charset=utf8', 'root', '');
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupération des filtres depuis la requête AJAX
$statut = $_POST['statut'];
$dateFin = $_POST['date_fin'];
$titre = $_POST['titre'];
$type = $_POST['type'];

// Préparez la requête SQL en fonction des filtres
$sql = "SELECT nom, description, score, favori FROM jeux_video WHERE 1";

if ($statut !== "Tous") {
    $sql .= " AND statut = :statut";
}

if (!empty($dateFin)) {
    $sql .= " AND date_fin = :date_fin";
}

if (!empty($titre)) {
    $sql .= " AND titre LIKE :titre";
}

if ($type !== "Tous") {
    $sql .= " AND type = :type";
}

// Préparation de la requête
$stmt = $pdo->prepare($sql);

// Liaison des paramètres
if ($statut !== "Tous") {
    $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
}

if (!empty($dateFin)) {
    $stmt->bindParam(':date_fin', $dateFin, PDO::PARAM_STR);
}

if (!empty($titre)) {
    $titreParam = '%' . $titre . '%'; // Ajoutez des % pour rechercher n'importe quelle correspondance
    $stmt->bindParam(':titre', $titreParam, PDO::PARAM_STR);
}

if ($type !== "Tous") {
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
}

// Exécution de la requête
$stmt->execute();

// Récupération des résultats
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fermeture de la connexion PDO
$pdo = null;

// Répondre au format JSON
header('Content-Type: application/json');
echo json_encode($resultats);
?>





