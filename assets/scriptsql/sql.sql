 CREATE DATABASE culture ;
 USE culture ;
 
 
CREATE TABLE user ( id_user INT AUTO_INCREMENT PRIMARY KEY, Nom VARCHAR(255) NOT NULL,Prenom VARCHAR(255) NOT NULL , Email VARCHAR(255) NOT NUL
 UNIQUE, Motdepasse VARCHAR(255) NOT NULL, ROLE ENUM('admin', 'user', 'visiteur'));
 

 CREATE TABLE Category ( id_category INT AUTO_INCREMENT PRIMARY KEY, id_admin INT NOT NULL , Nom VARCHAR(255) NOT NULL )
       FOREIGN KEY (id_admin) REFERENCES user(id_user) ON DELETE CASCADE ON UPDATE CASCADE

 ;

CREATE TABLE Articles ( 
  id_article INT AUTO_INCREMENT PRIMARY KEY,
   Titre VARCHAR(255) NOT NULL, Contenu TEXT NOT NULL,
	 id_auteur INT, 
	 id_category INT, 
	 Statut ENUM('Soumis', 'Accepté', 'Refusé') NOT NULL,
	  DateCréation TIMESTAMP DuserEFAUL
  T CURRENT_TIMESTAMP,
   DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   Image VARCHAR (500);
	 
       FOREIGN KEY (id_category) REFERENCES category(id_category)ON DELETE CASCADE ON UPDATE CASCADE, 
    FOREIGN KEY (id_auteur) REFERENCES user(id_user)ON DELETE CASCADE ON UPDATE CASCADE);