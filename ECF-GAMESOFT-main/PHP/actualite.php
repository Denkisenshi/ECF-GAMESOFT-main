<?php
// Connexion à la base de données (à personnaliser)
try {
    $pdo = new PDO('mysql:host=localhost;dbname=tableau_jeu;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs PDO
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

// Requête SQL pour récupérer les actualités (à personnaliser)
$sql = "SELECT titre, contenu FROM actualites ORDER BY date_publication DESC LIMIT 1"; // Vous pouvez ajuster la requête pour obtenir les dernières actualités

try {
    // Préparation et exécution de la requête
    $stmt = $pdo->query($sql);

    // Créez un tableau HTML avec les actualités
    $html = '<ul>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $html .= '<li><strong>' . htmlspecialchars($row['titre']) . '</strong><br>' . htmlspecialchars($row['contenu']) . '</li>';
    }
    $html .= '</ul>';

    // Envoyez le contenu HTML en réponse
    echo $html;
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>
