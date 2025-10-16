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

-- user story 2
-- info email, mdp, pseudo (5 lignes minimum)
INSERT INTO main_user(email, mdp, pseudo)
VALUES     ('lunar.fox92@mail.com', 'T!ger$2025', 'PixelRider'),
           ('zephyr.wave88@outlook.com', 'BlueMoon#47', 'ShadowNova'),
        ('nova.sparkle77@gmail.com', 'Z3nith!Sky', 'FrostByteX'),
        ('echo.shadow13@yahoo.com', 'P@ssw0rdX9', 'EchoDrift'),
        ('crimson.tide55@protonmail.com', 'Cr1mson*Edge', 'NeonVortex');



-- info jeu (1 lignes minimum)
INSERT INTO game(game_name)
VALUES     ('Power Of Memory'); 



-- info score (2 lignes minimum)
INSERT INTO score (user_id, game_id, difficulty, score, created_at) 
Values(1, 1, '1',10, '2025-10-14 12:00'),(2, 1, '2',20, '2025-10-14 12:00');

-- user story 5
SELECT * FROM main_user WHERE email = 'jnffbj@gmail.com' AND mdp ='gfbyvuhgeu764364';
-- fin user story 5



-- user story 6
SELECT 
g.game_name,
m.pseudo,
s.difficulty,
s.score,
s.created_at
FROM score as s 
LEFT JOIN main_user as m
ON s.user_id = m.id
LEFT JOIN game as g 
ON s.game_id = g.id
-- fin user story 6


