CREATE DATABASE projet_flash CHARACTER SET 'utf8';



-- user story 1 et 3
-- création de la table de l'utilisateur
CREATE TABLE main_user (
    id INT UNSIGNED  AUTO_INCREMENT,
    email VARCHAR(256) NOT NULL UNIQUE, -- textarea de lemail avec 256 caractère max
    mdp VARCHAR(256) NOT NULL UNIQUE, -- textarea du mot de passe avec 256 caractère max
    pseudo VARCHAR(256) NOT NULL UNIQUE, -- textarea du pseudo avec 256 caractère max
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- inscription 
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- derniere connexion
    PRIMARY KEY (id)
)
CHARACTER SET 'utf8'
ENGINE = INNODB;



-- création de la table du jeu
CREATE TABLE game (
    id INT UNSIGNED AUTO_INCREMENT,
    game_name TEXT NOT NULL,
    PRIMARY KEY (id)
)
CHARACTER SET 'utf8'
ENGINE = INNODB;
