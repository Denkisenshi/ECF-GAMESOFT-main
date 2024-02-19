CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(255),
    reset_token_expiration DATETIME,
    role VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    verification_token VARCHAR(255)
);



CREATE TABLE producteurs_managers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    account_type VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL
);


CREATE TABLE jeux_video (
    id INT PRIMARY KEY AUTO_INCREMENT,
    budget DECIMAL(10, 2),
    commentaire TEXT,
    dateMiseAjour DATE,
    date_debut DATE,
    date_fin DATE,
    description TEXT,
    joueurs INT,
    moteur VARCHAR(255),
    poids DECIMAL(10, 2),
    score INT,
    statut VARCHAR(255),
    studio VARCHAR(255),
    support VARCHAR(255),
    titre VARCHAR(255),
    type VARCHAR(255)
);


CREATE TABLE favoris (
    id INT PRIMARY KEY AUTO_INCREMENT,
    jeu_id INT,
    utilisateur_id INT,
    FOREIGN KEY (jeu_id) REFERENCES jeux_video(id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

CREATE TABLE actualites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_publication DATE NOT NULL
);
