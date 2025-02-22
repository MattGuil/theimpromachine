CREATE OR REPLACE TABLE impros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  game_id INT NOT NULL,
  type ENUM("Mixte", "Comparée") NOT NULL,
  nb_joueurs INT NOT NULL,                       -- -1 => nombre de joueurs illimité
  duree INT NOT NULL,
  categorie_id INT NOT NULL,
  theme VARCHAR(255) NOT NULL,
  vainqueur VARCHAR(255),
  FOREIGN KEY (game_id) REFERENCES games(id),
  FOREIGN KEY (categorie_id) REFERENCES categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO impros (game_id, type, nb_joueur, duree, categorie_id, theme, vainqueur)
VALUES
(1, 'Mixte', -1, 5, 1, 'Thème 1', NULL),
(1, 'Comparée', 2, 4, 2, 'Thème 2', NULL),
(1, 'Mixte', -1, 6, 3, 'Thème 3', NULL),
(2, 'Mixte', -1, 5, 4, 'Thème 4', NULL),
(2, 'Comparée', 2, 4, 5, 'Thème 5', NULL),
(2, 'Mixte', -1, 6, 6, 'Thème 6', NULL),
(3, 'Mixte', -1, 5, 7, 'Thème 7', NULL),
(3, 'Comparée', 2, 4, 8, 'Thème 8', NULL),
(3, 'Mixte', -1, 6, 9, 'Thème 9', NULL);
