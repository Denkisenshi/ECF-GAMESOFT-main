<?php
// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=tableau_jeu;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
    exit();
}

// Récupération des données du formulaire
$titre = $_POST['titre'];
$description = $_POST['description'];
$studio = $_POST['studio'];
$support = $_POST['support'];
$poids = $_POST['poids'];
$score = $_POST['score'];
$moteur = $_POST['moteur'];
$date_debut = $_POST['date_debut'];
$dateMiseAJour = $_POST['dateMiseAJour'];
$date_fin = $_POST['date_fin'];
$budget = $_POST['budget'];
$statut = $_POST['statut'];
$type = $_POST['type'];
$joueurs = $_POST['joueurs'];

// Requête SQL pour insérer les données du jeu dans la base de données
$sql = "INSERT INTO jeux_video (titre, description, studio, support, poids, score, moteur, date_debut, dateMiseAJour, date_fin, budget, statut, type, joueurs) VALUES (:titre, :description, :studio, :support, :poids, :score, :moteur, :date_debut, :dateMiseAJour, :date_fin, :budget, :statut, :type, :joueurs)";

try {
    // Préparation de la requête
    $stmt = $pdo->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':studio', $studio, PDO::PARAM_STR);
    $stmt->bindParam(':support', $support, PDO::PARAM_STR);
    $stmt->bindParam(':poids', $poids, PDO::PARAM_STR);
    $stmt->bindParam(':score', $score, PDO::PARAM_STR);
    $stmt->bindParam(':moteur', $moteur, PDO::PARAM_STR);
    $stmt->bindParam(':date_debut', $date_debut, PDO::PARAM_STR);
    $stmt->bindParam(':dateMiseAJour', $dateMiseAJour, PDO::PARAM_STR);
    $stmt->bindParam(':date_fin', $date_fin, PDO::PARAM_STR);
    $stmt->bindParam(':budget', $budget, PDO::PARAM_STR);
    $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
    $stmt->bindParam(':joueurs', $joueurs, PDO::PARAM_STR);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Jeu créé avec succès.";
    } else {
        echo "Erreur lors de la création du jeu : " . $stmt->errorInfo()[2];
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}

// Fermeture de la connexion
$pdo = null;
?>
