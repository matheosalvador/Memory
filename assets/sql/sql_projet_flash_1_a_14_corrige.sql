CREATE DATABASE projet_flash CHARACTER SET 'utf8';



-- user story 1 et 3
-- création de la table de l'utilisateur
CREATE TABLE main_user (
    id INT UNSIGNED  AUTO_INCREMENT,
    email VARCHAR(256) NOT NULL UNIQUE, -- textarea de lemail avec 256 caractère max
    mdp VARCHAR(256) NOT NULL , -- textarea du mot de passe avec 256 caractère max
    pseudo VARCHAR(256) NOT NULL UNIQUE, -- textarea du pseudo avec 256 caractère max
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- inscription 
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- derniere connexion
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



-- création de la table des messages
CREATE TABLE message (
    id INT UNSIGNED  AUTO_INCREMENT,
    game_id INT UNSIGNED  NOT NULL,
    user_id INT UNSIGNED  NOT NULL ,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP, -- date des messages (mis à jour)
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES main_user(id),
    FOREIGN KEY (game_id) REFERENCES game(id)
)
CHARACTER SET 'utf8'
ENGINE = INNODB;
-- fin user story 1 et 3



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



--user story 9
-- info message (25 lignes minimum)
INSERT INTO message(message, game_id, user_id)
VALUES    ('Salut, t’es dispo ?', 1, 1),
        ('Ouais, je finis à 18h.', 1, 2),
        ('Parfait, on se retrouve vers 19h au café ?', 1, 1),
        ('Ça marche, j’ai hâte !', 1, 2),
        ('T’as vu le dernier épisode de la série ?', 1, 1),
        ('Non, pas encore, spoil pas !', 1, 2),
        ('Promis, mais tu vas kiffer.', 1, 1),
        ('Tu me connais trop bien haha.', 1, 2),
        ('Tu ramènes ton ordi ce soir ?', 1, 1),
        ('Ouais, on pourra bosser un peu aussi.', 1, 2),
        ('Cool, j’ai avancé sur le projet.', 1, 1),
        ('Trop bien, montre-moi ça !', 1, 2),
        ('Tu veux manger sur place ou commander ?', 1, 1),
        ('On peut commander, j’ai la flemme de bouger.', 1, 2),
        ('Ok, pizza comme d’hab ?', 1, 1),
        ('Grave, quatre fromages pour moi.', 1, 2),
        ('Et une végétarienne pour moi.', 1, 1),
        ('Tu prends des boissons ?', 1, 2),
        ('Ouais, je passe au supermarché avant.', 1, 1),
        ('Top, je ramène les plaids.', 1, 2),
        ('On va passer une bonne soirée !', 1, 1),
        ('Comme toujours avec toi.', 1, 2),
        ('À tout à l’heure alors !', 1, 1),
        ('Bonne nuit !', 1, 2),
        ('Désolé je suis pas disponible', 1, 1);
-- fin user story 9
-- fin de user story 2



-- user story 4
-- verification email non double
UPDATE main_user AS mu
LEFT JOIN (
    SELECT email FROM main_user WHERE email = 'jnffbj@gmail.com'
) AS doublon ON doublon.email IS NOT NULL
SET mu.email = 'jnffbj@gmail.com'
WHERE mu.id = 1 AND doublon.email IS NULL;
SELECT * FROM main_user WHERE email = 'xxx';

-- modification mot de passe
UPDATE main_user
SET mdp = 'xxx'
WHERE id = '1';
-- fin user story 4



-- user story 5
SELECT * FROM main_user WHERE email = 'jnffbj@gmail.com' AND mdp ='gfbyvuhgeu764364';
-- fin user story 5



-- user story 6
--a mettre dans game
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



-- user story 8
-- user story 7
-- (a mettre dans score)
SELECT game.game_name, main_user.pseudo, score.difficulty, score.score, score.created_at
FROM score 
JOIN main_user ON score.user_id = main_user.id -- jointure entre score et main_user
JOIN game ON game.id = score.game_id -- jointure entre jeu et score
WHERE main_user.pseudo LIKE '%%' -- recherche de pseudo (avec modulo %%)
ORDER BY score.difficulty, score.score;
-- fin user story 7

ALTER TABLE score
ADD updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP -- (on a oublié d'ajouter ça)

-- update le score de qlq1 à 200
UPDATE score 
SET difficulty = 2, game_id = 1,
    updated_at = CURRENT_TIMESTAMP;
-- fin user story 8



-- user story 10
-- ajout de la table isSender
ALTER TABLE message 
ADD isSender TINYINT(1);

-- la colonne isSender (booleen) modifié
UPDATE message
SET isSender = CASE 
                  WHEN user_id = 3 THEN 1 
                  ELSE 0 
               END;

-- contenu message + nom du joueur + date et heure
SELECT 
    m.message,
    u.pseudo,
    m.user_id,
    m.created_at
FROM message m
JOIN main_user u ON m.user_id = u.id
WHERE m.created_at >= NOW() - INTERVAL 1 DAY
ORDER BY m.created_at ASC
LIMIT 1;
-- fin user story 10



-- user story 11
CREATE TABLE messagerie_privee (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_sender_id INT UNSIGNED NOT NULL,
    user_receiver_id INT UNSIGNED NOT NULL,
    msg TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    read_at DATETIME NULL,
    PRIMARY KEY (id)
)
-- fin user story 11



-- user story 12
-- Insertion des messages avec NOW() pour les dates
INSERT INTO messagerie_privee (msg, is_read, read_at, created_at, user_sender_id, user_receiver_id) 
VALUES
  ('Yo, tu va bien', 1, NOW(), NOW(), 1, 2),
  ('Oe tranquille', 0, NOW(), NOW(), 2, 1),
  ('cv bieng', 1, NULL, NOW(), 3, 3),
  ('vous voulez jouer a un jeu?', 1, NULL, NOW(), 1, 1),
  ('az', 1, NOW(), NOW(), 2, 3),
  ('go apex?', 1, NULL, NOW(), 1, 2),
  ('aller', 0, NULL, NOW(), 2, 2),
  ('vas-y', 1, NOW(), NOW(), 3, 1),
  ('apres je peux pas mtn', 1, NOW(), NOW(), 2, 1),
  ('ah', 0, NULL, NOW(), 1, 3),
  ('après on est le midi, ce soir t dispo?', 1, NULL, NOW(), 3, 3),
  ('en vrai ouais je crois', 1, NOW(), NOW(), 2, 2),
  ('aller ba go ce soir', 1, NULL, NOW(), 1, 2),
  ('pense a prendre ta souris !', 0, NOW(), NOW(), 2, 1),
  ('ok je penserais a ca', 0, NULL, NOW(), 1, 1),
  ('et change de clavier, passe a un querty', 0, NULL, NOW(), 3, 3),
  ('ba il va très bien mon azerty', 1, NOW(), NOW(), 1, 3),
  ('la map D:', 0, NULL, NOW(), 2, 2),
  ('ça marche, bon ba a ce soir :))', 1, NOW(), NOW(), 1, 2),
  ('aller', 1, NULL, NOW(), 2, 1);



-- les tests
-- message supplémentaires
INSERT INTO messagerie_privee (msg, is_read, read_at, created_at, user_sender_id, user_receiver_id)
VALUES
  ('ah et pense a installer le jeu aussi :]', 1, NOW(), NOW(), 3, 2),
  ('oe tkt je penserais a ca', 1, NOW(), NOW(), 2, 1);

-- update message
UPDATE messagerie_privee
SET msg = 'pas de clavier'
WHERE id = 24;

DELETE FROM messagerie_privee
WHERE id=24
-- fin user story 12


    
-- user story 13
-- valeur pour tester la messagerie privée (insérer des valeurs)
INSERT INTO messagerie_privee(user_sender_id, user_receiver_id, msg, is_read, created_at, read_at) VALUES
(1, 2, 'Yo ShadowNova, prêt pour la session de test ?', 1, '2025-10-16 08:00:00', '2025-10-16 08:05:00'),
(2, 1, 'Toujours prêt PixelRider ', 1, '2025-10-16 08:07:00', '2025-10-16 08:08:00'),
(1, 3, 'Salut FrostByteX, tu peux checker mon dernier commit ?', 0, '2025-10-16 09:00:00', NULL),
(3, 1, 'Oui, je regarde ça tout de suite.', 1, '2025-10-16 09:15:00', '2025-10-16 09:17:00'),
(4, 2, 'ShadowNova, tu viens à la réunion de ce soir ?', 0, '2025-10-15 18:00:00', NULL),
(2, 4, 'Oui EchoDrift, je serai là vers 18h30.', 1, '2025-10-15 18:10:00', '2025-10-15 18:11:00'),
(5, 1, 'Yo PixelRider, on lance une partie de Marinbad ?', 0, '2025-10-16 10:00:00', NULL),
(1, 5, 'Grave ! Envoie-moi ton code de salle.', 1, '2025-10-16 10:05:00', '2025-10-16 10:07:00'),
(3, 4, 'EchoDrift, t’as vu le nouveau patch du jeu ?', 1, '2025-10-15 19:00:00', '2025-10-15 19:02:00'),
(4, 3, 'Oui FrostByteX, les graphismes sont fous !', 1, '2025-10-15 19:05:00', '2025-10-15 19:06:00');

SELECT 
    m.id,
    sender.pseudo AS sender_pseudo,
    receiver.pseudo AS receiver_pseudo,
    m.msg,
    m.created_at,
    m.read_at,
    m.is_read
FROM messagerie_privee AS m
JOIN main_user AS sender
    ON sender.id = m.user_sender_id
JOIN main_user AS receiver 
    ON receiver.id = m.user_receiver_id
JOIN (
    SELECT 
        (user_sender_id + user_receiver_id) AS conversation_sum,
        MAX(created_at) AS last_message_date
    FROM messagerie_privee
    WHERE 1 IN (user_sender_id, user_receiver_id)
    GROUP BY (user_sender_id + user_receiver_id)
) AS conv
    ON (m.user_sender_id + m.user_receiver_id) = conv.conversation_sum
    AND m.created_at = conv.last_message_date
WHERE 1 IN (m.user_sender_id, m.user_receiver_id)
ORDER BY m.created_at DESC;
-- fin de user story 13



-- user story 14
SELECT 
    mp.id AS message_id,
    sender.pseudo AS sender_pseudo,
    receiver.pseudo AS receiver_pseudo,
    mp.msg AS message,
    mp.created_at AS sent_at,
    mp.read_at AS read_at,
    mp.is_read,

    -- Statistiques expéditeur
    (SELECT COUNT(*) FROM score s WHERE s.user_id = mp.user_sender_id) AS sender_total_games, -- requete pour expediteur
    (SELECT g.game_name
     FROM score s
     JOIN game g ON s.game_id = g.id
     WHERE s.user_id = mp.user_sender_id
     GROUP BY s.game_id
     ORDER BY COUNT(*) DESC
     LIMIT 1) AS sender_most_played_game,

    -- Statistiques receveur
    (SELECT COUNT(*) FROM score s WHERE s.user_id = mp.user_receiver_id) AS receiver_total_games, -- requete pour receveur
    (SELECT g.game_name
     FROM score s
     JOIN game g ON s.game_id = g.id
     WHERE s.user_id = mp.user_receiver_id
     GROUP BY s.game_id
     ORDER BY COUNT(*) DESC
     LIMIT 1) AS receiver_most_played_game

FROM messagerie_privee mp
JOIN main_user sender ON sender.id = mp.user_sender_id
JOIN main_user receiver ON receiver.id = mp.user_receiver_id
WHERE 
    (mp.user_sender_id = 1 AND mp.user_receiver_id = 2)
    OR
    (mp.user_sender_id = 2 AND mp.user_receiver_id = 1)
ORDER BY mp.created_at ASC;
-- fin user story 14

--ajout de la colone temps de jeu sur la table score
ALTER TABLE score
ADD COLUMN time INT NOT NULL DEFAULT 0;

CREATE TABLE records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    difficulty ENUM('1','2','3') NOT NULL,  -- même type que dans score
    record_time INT NOT NULL,               -- en secondes
    player_id INT UNSIGNED NULL,            -- joueur qui détient le record
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_difficulty (difficulty),
    FOREIGN KEY (player_id) REFERENCES main_user(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8;

ALTER TABLE records
ADD COLUMN record_count INT UNSIGNED NOT NULL DEFAULT 0;

CREATE TABLE record_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    difficulty ENUM('1','2','3') NOT NULL,
    record_time INT NOT NULL,      -- temps battu
    player_id INT UNSIGNED NULL,
    beaten_at DATE NOT NULL,        -- date où le record a été battu
    FOREIGN KEY (player_id) REFERENCES main_user(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO records (difficulty, record_time, player_id, updated_at)
VALUES (1, 120, 1, NOW());

INSERT INTO record_history (difficulty, record_time, player_id, beaten_at)
VALUES (1, 120, 1, CURDATE());

ALTER TABLE main_user
ADD COLUMN last_activity DATETIME DEFAULT NULL;

SELECT 
    stats.annee,
    stats.mois,

    -- TOP 1
    (SELECT u.pseudo
     FROM score s2
     JOIN main_user u ON u.id = s2.user_id
     WHERE YEAR(s2.created_at) = stats.annee
       AND MONTH(s2.created_at) = stats.mois
     GROUP BY s2.user_id
     ORDER BY SUM(s2.score) DESC
     LIMIT 1) AS top1,

    -- TOP 2
    (SELECT u.pseudo
     FROM score s2
     JOIN main_user u ON u.id = s2.user_id
     WHERE YEAR(s2.created_at) = stats.annee
       AND MONTH(s2.created_at) = stats.mois
     GROUP BY s2.user_id
     ORDER BY SUM(s2.score) DESC
     LIMIT 1 OFFSET 1) AS top2,

    -- TOP 3
    (SELECT u.pseudo
     FROM score s2
     JOIN main_user u ON u.id = s2.user_id
     WHERE YEAR(s2.created_at) = stats.annee
       AND MONTH(s2.created_at) = stats.mois
     GROUP BY s2.user_id
     ORDER BY SUM(s2.score) DESC
     LIMIT 1 OFFSET 2) AS top3,

    -- TOTAL PARTIES
    stats.total_parties,

    -- JEU LE PLUS JOUÉ
    (SELECT g.game_name
     FROM score s2
     JOIN game g ON g.id = s2.game_id
     WHERE YEAR(s2.created_at) = stats.annee
       AND MONTH(s2.created_at) = stats.mois
     GROUP BY s2.game_id
     ORDER BY COUNT(*) DESC
     LIMIT 1) AS jeu_le_plus_joue

FROM (
    SELECT
        YEAR(s.created_at) AS annee,
        MONTH(s.created_at) AS mois,
        COUNT(*) AS total_parties
    FROM score s
    WHERE YEAR(s.created_at) = 2025
    GROUP BY YEAR(s.created_at), MONTH(s.created_at)
) AS stats
ORDER BY stats.mois ASC;
------------------------------------------------------
SELECT 
    stats.annee,
    stats.mois,

    -- TOTAL PARTIES DU JOUEUR
    stats.total_parties,

    -- JEU LE PLUS JOUÉ (par le joueur)
    (SELECT g.game_name
     FROM score s2
     JOIN game g ON g.id = s2.game_id
     WHERE s2.user_id = 1
       AND YEAR(s2.created_at) = stats.annee
       AND MONTH(s2.created_at) = stats.mois
     GROUP BY s2.game_id
     ORDER BY COUNT(*) DESC
     LIMIT 1) AS jeu_le_plus_joue,

    -- SCORE MOYEN DU JOUEUR DANS LE MOIS
    stats.score_moyen

FROM (
    SELECT 
        YEAR(s.created_at) AS annee,
        MONTH(s.created_at) AS mois,
        COUNT(*) AS total_parties,
        AVG(s.score) AS score_moyen
    FROM score s
    WHERE s.user_id = 1
      AND YEAR(s.created_at) = 2025
    GROUP BY YEAR(s.created_at), MONTH(s.created_at)
) AS stats

ORDER BY stats.mois ASC;
------------------------------------------------------


SELECT 
    stats.annee,
    stats.mois,

    stats.total_parties,

    -- Jeu le plus joué du joueur dans le mois
    (SELECT g.game_name
     FROM score s2
     JOIN game g ON g.id = s2.game_id
     WHERE s2.user_id = 1
       AND YEAR(s2.created_at) = stats.annee
       AND MONTH(s2.created_at) = stats.mois
     GROUP BY s2.game_id
     ORDER BY COUNT(*) DESC
     LIMIT 1) AS jeu_le_plus_joue,

    stats.score_moyen

FROM (
    SELECT 
        YEAR(s.created_at) AS annee,
        MONTH(s.created_at) AS mois,
        COUNT(*) AS total_parties,
        AVG(s.score) AS score_moyen
    FROM score s
    WHERE s.user_id = 1
      AND YEAR(s.created_at) = 2025
    GROUP BY YEAR(s.created_at), MONTH(s.created_at)
) AS stats

ORDER BY stats.mois ASC;

