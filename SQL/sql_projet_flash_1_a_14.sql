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



-- création de la table de score
CREATE TABLE score (
    id INT UNSIGNED  AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    game_id INT UNSIGNED NOT NULL,
    difficulty ENUM ('1','2','3') NOT NULL, -- niveau de difficulté
    score INT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES main_user(id),
    FOREIGN KEY (game_id) REFERENCES game(id)
)
CHARACTER SET 'utf8'
ENGINE = INNODB;
