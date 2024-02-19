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

// Configuration AWS SDK
require 'vendor/autoload.php';

use Aws\Ses\SesClient;

$sesClient = new SesClient([
    'version' => 'latest',
    'region' => 'eu-west-3', // Change this to your desired AWS region
    'credentials' => [
        'key' => 'AKIAQX4W3KXOSQ6UTFH6',
        'secret' => 'VbUK/qLMV8w8ajW5xlhLDg4WdgUngA+MvtXhLWls',
    ],
]);

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validation des données (vous pouvez ajouter plus de règles de validation personnalisées ici)

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        redirectToError("Tous les champs sont obligatoires.");
    } else if ($password !== $confirm_password) {
        redirectToError("Les mots de passe ne correspondent pas.");
    } else {
        // Vérifier si l'adresse e-mail existe déjà dans la base de données
        $stmt = $pdo->prepare("SELECT email FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();

        if ($result) {
            // L'adresse e-mail existe déjà, renvoyez un message d'erreur à l'utilisateur
            redirectToError("L'adresse e-mail existe déjà dans la base de données.");
        } else {
            // L'adresse e-mail est unique, continuez avec l'insertion
            // Hachage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Préparation et exécution de la requête d'insertion
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);

            if ($stmt->rowCount() > 0) {
                // Génération du lien de vérification
                $verification_token = bin2hex(random_bytes(32)); // Génère un jeton de vérification aléatoire
                $verification_link = "https://http://localhost/ECF-GAMESOFT-main/verification.html?token=" . $verification_token;
                
                // Enregistrement du lien de vérification dans la base de données
                $stmt = $pdo->prepare("UPDATE utilisateurs SET verification_token = ? WHERE email = ?");
                $stmt->execute([$verification_token, $email]);

                // Envoi de l'e-mail de vérification via Amazon SES
                $subject = "Vérification de votre adresse e-mail";
                $message = "Cliquez sur le lien suivant pour vérifier votre adresse e-mail : " . $verification_link;

                // Utilisez votre adresse e-mail vérifiée comme expéditeur
                $senderEmail = "YOUR_VERIFIED_EMAIL_ADDRESS";

                // Envoie de l'e-mail via Amazon SES
                $result = $sesClient->sendEmail([
                    'Source' => $senderEmail,
                    'Destination' => [
                        'ToAddresses' => [$email], // L'adresse e-mail du destinataire
                    ],
                    'Message' => [
                        'Subject' => [
                            'Data' => $subject,
                            'Charset' => 'UTF-8',
                        ],
                        'Body' => [
                            'Html' => [
                                'Data' => $message,
                                'Charset' => 'UTF-8',
                            ],
                        ],
                    ],
                ]);

                if ($result['MessageId']) {
                    // Redirection vers une page de confirmation ou de connexion
                    header("Location: confirmation.html");
                    exit();
                } else {
                    redirectToError("Erreur lors de l'envoi de l'e-mail de vérification. Veuillez réessayer.");
                }
            } else {
                redirectToError("Erreur lors de l'insertion des données dans la base de données.");
            }
        }
    }
}

// Fonction pour rediriger vers une page d'erreur avec un message
function redirectToError($message) {
    header("Location: formulaire.html?error=1&message=" . urlencode($message));
    exit();
}
?>



