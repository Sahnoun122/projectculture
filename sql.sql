CREATE DATABASE culture;
USE culture;

CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL,
    Prenom VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Motdepasse VARCHAR(255) NOT NULL,
    profile VARCHAR(255),
    ROLE ENUM('admin', 'user', 'visiteur')
);

CREATE TABLE Category (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    id_admin INT NOT NULL,
    Nom VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_admin) REFERENCES user(id_user) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Articles (
    id_article INT AUTO_INCREMENT PRIMARY KEY,
    Titre VARCHAR(255) NOT NULL,
    Contenu TEXT NOT NULL,
    id_auteur INT,
    id_category INT,
    Statut ENUM('Soumis', 'Accepté', 'Refusé') NOT NULL,
    DateCréation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Image VARCHAR(500),
    FOREIGN KEY (id_category) REFERENCES Category(id_category) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_auteur) REFERENCES user(id_user) ON DELETE CASCADE ON UPDATE CASCADE
);








    SELECT c.Nom AS Category, COUNT(a.id_article) AS Total_Articles
FROM Articles a
JOIN Category c ON a.id_category = c.id_category
WHERE a.Statut = 'Accepté'
GROUP BY c.Nom;


SELECT u.Nom AS Author, u.Prenom AS FirstName, COUNT(a.id_article) AS Total_Articles
FROM Articles a
JOIN user u ON a.id_auteur = u.id_user
WHERE a.Statut = 'Accepté'
GROUP BY u.Nom, u.Prenom
ORDER BY Total_Articles DESC;

SELECT c.Nom AS Category, AVG(ArticlesCount) AS Average_Articles
FROM (
    SELECT c.id_category, COUNT(a.id_article) AS ArticlesCount
    FROM Articles a
    JOIN Category c ON a.id_category = c.id_category
    WHERE a.Statut = 'Accepté'
    GROUP BY c.id_category
) AS CategoryArticles
JOIN Category c ON CategoryArticles.id_category = c.id_category
GROUP BY c.Nom;


CREATE VIEW Derniers_Articles AS
SELECT a.Titre, a.Contenu, a.DateCréation, u.Nom AS Author, u.Prenom AS FirstName
FROM Articles a
JOIN user u ON a.id_auteur = u.id_user
WHERE a.DateCréation >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)
AND a.Statut = 'Accepté'
ORDER BY a.DateCréation DESC;


SELECT c.Nom AS Category
FROM Category c
LEFT JOIN Articles a ON c.id_category = a.id_category
WHERE a.id_article IS NULL;
