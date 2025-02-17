CREATE OR REPLACE TABLE games (
  id INT AUTO_INCREMENT PRIMARY KEY,
  arbitre VARCHAR(25) NOT NULL,
  equipe_1 VARCHAR(255) NOT NULL,
  equipe_2 VARCHAR(255) NOT NULL,
  vainqueur VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO games (arbitre, equipe_1, equipe_2, vainqueur)
VALUES
('Matt', 'Les Improvisateurs', 'Les Comédiens', NULL),
('Matt', 'Les Acteurs', 'Les Performers', NULL),
('Matt', 'Les Artistes', 'Les Talents', NULL);
