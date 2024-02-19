<?php
// Configuration de la base de données
$servername = "localhost"; // Nom du serveur de base de données
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$dbname = "tableau_jeu"; // Nom de la base de données

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("La connexion à la base de données a échoué : " . $e->getMessage());
}

// Requête SQL pour récupérer les jeux vidéo
$sql = "SELECT id, titre, date_debut, score FROM jeux_video";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row["titre"] . "</td>";
        echo "<td>" . $row["date_debut"] . "</td>";
        echo "<td>" . $row["score"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Aucun jeu vidéo trouvé.</td></tr>";
}

// Fermeture de la connexion à la base de données
$pdo = null;
?>


