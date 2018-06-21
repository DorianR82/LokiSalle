CREATE DATABASE lokisalle;
USE lokisalle;

CREATE TABLE salle(
    id_salle int(3) NOT NULL AUTO_INCREMENT,
    titre VARCHAR(200) NOT NULL,
    description text,
    photo VARCHAR(200),
    pays VARCHAR(20),
    ville VARCHAR(20) NOT NULL,
    adresse VARCHAR(50) NOT NULL,
    cp int(5) NOT NULL,
    capacite INT(3) NOT NULL,
    categorie ENUM('réunion','bureau','formation') NOT NULL,
    PRIMARY KEY (id_salle)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE membre(
    id_membre INT(3) NOT NULL AUTO_INCREMENT,
    pseudo VARCHAR(20) NOT NULL,
    mdp VARCHAR(60) NOT NULL,
    nom VARCHAR(20) NOT NULL,
    prenom VARCHAR(20) NOT NULL,
    email  VARCHAR(50) NOT NULL,
    civilite ENUM('M','F') NOT NULL,
    statut INT(1) NOT NULL,
    date_inscription DATETIME NOT NULL,
    PRIMARY KEY (id_membre)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE produit(
    id_produit INT(3) NOT NULL AUTO_INCREMENT,
    id_salle INT(3) NOT NULL,
    date_arrivee DATETIME NOT NULL,
    date_depart DATETIME DEFAULT NULL,
    prix int(5) NOT NULL,
    etat ENUM('libre','reservation') NOT NULL,
    PRIMARY KEY (id_produit)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE commande(
    id_commande INT(3) NOT NULL AUTO_INCREMENT,
    id_membre INT(3) NOT NULL,
    id_produit INT(3) NOT NULL,
    date_enregistrement DATETIME NOT NULL,
    PRIMARY KEY (id_commande)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE avis(
    id_avis INT(3) NOT NULL AUTO_INCREMENT,
    id_membre INT(3) NOT NULL,
    id_salle INT(3) NOT NULL,
    note INT(2) NOT NULL,
    commentaire text,
    date_enregistrement DATETIME NOT NULL,
    PRIMARY KEY (id_avis)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO membre(pseudo,mdp,nom,prenom,email,civilite,statut,date_inscription) VALUE ('admin','zizi','Thoyer','Marie','marie.thoyer@gmail.com','F','1','2016-06-06 14:45:00');