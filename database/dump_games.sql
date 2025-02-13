CREATE OR REPLACE TABLE games (
  id INT AUTO_INCREMENT PRIMARY KEY,
  arbitre VARCHAR(25) NOT NULL,
  equipe_1 VARCHAR(255) NOT NULL,
  equipe_2 VARCHAR(255) NOT NULL,
  equipe_1_score INT,
  equipe_2_score INT,
  statut ENUM('Créé', 'En cours', 'Terminé') NOT NULL DEFAULT 'Créé',     
  vainqueur VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO games (arbitre, equipe_1, equipe_2, equipe_1_score, equipe_2_score, statut, vainqueur)
VALUES
('Matt', 'Les Improvisateurs', 'Les Comédiens', NULL, NULL, 'Créé', NULL),
('Matt', 'Les Acteurs', 'Les Performers', NULL, NULL, 'Créé', NULL),
('Matt', 'Les Artistes', 'Les Talents', NULL, NULL, 'Créé', NULL);
