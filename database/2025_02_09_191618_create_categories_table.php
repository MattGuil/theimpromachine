<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('categories');

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('type', [
                'Catégorie de style',
                'Catégorie d\'expression',
                'Catégorie de contraintes',
                'Catégorie de structure',
                'Catégorie par ajout'
            ]);
            $table->text('description')->nullable();
            $table->boolean('mixte');
            $table->boolean('comparee');
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ['nom' => 'À la manière de Molière', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des œuvres de Molière.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Marcel Pagnol', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des œuvres de Marcel Pagnol.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de William Shakespeare', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des œuvres de Shakespeare.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Tex Avery', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des dessins animés de Tex Avery.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Charlie Chaplin', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films de Charlie Chaplin.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Alfred Hitchcock', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films de Hitchcock.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Raymond Devos', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des sketches de Raymond Devos.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Samuel Beckett', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des œuvres de Beckett.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Tarantino', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films de Tarantino.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Nolan', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films de Nolan.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Scorsese', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films de Scorsese.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Steven Spielberg', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films de Spielberg.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Jules Verne', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des romans de Jules Verne.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de Jean de La Fontaine', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des fables de La Fontaine.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du théâtre de boulevard', 'type' => 'Catégorie de style', 'description' => 'Style inspiré du théâtre de boulevard.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du documentaire', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des documentaires.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de la comédie musicale', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des comédies musicales.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du drame', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des drames.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du spot publicitaire', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des publicités.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de la bande-annonce', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des bandes-annonces.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de la science-fiction', 'type' => 'Catégorie de style', 'description' => 'Style inspiré de la science-fiction.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de l\'heroic-fantasy', 'type' => 'Catégorie de style', 'description' => 'Style inspiré de l\'heroic-fantasy.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de la sitcom', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des sitcoms.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du roman/film policier', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des romans et films policiers.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du roman/film d\'aventure', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des romans et films d\'aventure.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du western', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des westerns.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du peplum', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des peplums.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du film de gangsters', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films de gangsters.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du film d\'horreur', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films d\'horreur.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du cartoon', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des cartoons.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière des contes et légendes', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des contes et légendes.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du théâtre antique', 'type' => 'Catégorie de style', 'description' => 'Style inspiré du théâtre antique.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de l\'épopée médiéval', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des épopées médiévales.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de la Comedia dell\'arte', 'type' => 'Catégorie de style', 'description' => 'Style inspiré de la Comedia dell\'arte.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du roman à l\'eau de rose', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des romans à l\'eau de rose.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du mélodrame', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des mélodrames.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière de la téléréalité', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des émissions de téléréalité.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière des mille et une nuits', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des contes des mille et une nuits.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du manga', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des mangas.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du cinéma muet', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films muets.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du suspense et grand frisson', 'type' => 'Catégorie de style', 'description' => 'Style inspiré des films à suspense.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'À la manière du théâtre de marionnette', 'type' => 'Catégorie de style', 'description' => 'Style inspiré du théâtre de marionnettes.', 'mixte' => false, 'comparee' => false],

            ['nom' => 'Rimée', 'type' => 'Catégorie d\'expression', 'description' => '', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Chantée', 'type' => 'Catégorie d\'expression', 'description' => 'Tout doit être chanté', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Comédie musicale', 'type' => 'Catégorie d\'expression', 'description' => 'Du chant, de la danse, des dialogues', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Jukebox', 'type' => 'Catégorie d\'expression', 'description' => 'Tous les dialogues doivent être chantés sur plusieurs styles musicaux imposés en indiquant des artistes. Les joueurs devront chanter sur les mélodies de ces chanteurs.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Texte imposé', 'type' => 'Catégorie d\'expression', 'description' => 'Les dialogues de l\'un des joueurs proviennent exclusivement d\'un texte (de théâtre, ou roman) préparé à l\'avance par l\'arbitre.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Sans parole', 'type' => 'Catégorie d\'expression', 'description' => 'Tous les bruitages, sons, grognements etc. sont autorisés, mais aucune parole distincte.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Silencieuse', 'type' => 'Catégorie d\'expression', 'description' => 'Aucun son quel qu\'il soit n\'est autorisé.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Doublage américain', 'type' => 'Catégorie d\'expression', 'description' => 'Des comédiens jouent dans la patinoire, et d\'autres font leurs voix.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Grommelot', 'type' => 'Catégorie d\'expression', 'description' => 'Langage inventé, improvisé, dont les mots n\'ont de sens que pour l\'acteur. Seule l\'intonation peut le traduire.', 'mixte' => false, 'comparee' => false],

            ['nom' => 'Mimée', 'type' => 'Catégorie de contraintes', 'description' => '', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Muette puis mimée', 'type' => 'Catégorie de contraintes', 'description' => 'Uniquement en comparée ; une équipe fait une impro muette, l\'autre refait la même en mimée.', 'mixte' => false, 'comparee' => true],
            ['nom' => 'Croisement', 'type' => 'Catégorie de contraintes', 'description' => 'Uniquement en mixte avec un joueur par équipe ; les deux joueurs doivent s\'échanger leur personnage quand l\'arbitre siffle.', 'mixte' => true, 'comparee' => false],
            ['nom' => 'Carnage', 'type' => 'Catégorie de contraintes', 'description' => 'Tous les improvisateurs participant au match doivent mourir avant la fin de l\'impro.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Abécédaire', 'type' => 'Catégorie de contraintes', 'description' => 'Expression en suivant l\'ordre alphabétique.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Switch', 'type' => 'Catégorie de contraintes', 'description' => 'Expression en changeant de rôle.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Zone d\'humeurs', 'type' => 'Catégorie de contraintes', 'description' => 'Expression en changeant d\'humeur.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Grosse colère', 'type' => 'Catégorie de contraintes', 'description' => 'Uniquement en mixte avec un joueur par équipe ; les jouteurs commencent l\'improvisation de manière cordiale, pour ensuite se disputer, la colère venant crescendo jusqu\'à la fin de l\'improvisation.', 'mixte' => true, 'comparee' => false],
            ['nom' => 'Humeur imposée', 'type' => 'Catégorie de contraintes', 'description' => 'L\'arbitre impose une humeur à chaque improvisateur en jeu, lequel devra donc garder cette humeur tout au long de l\'impro. En cas de service, l\'arbitre interrompt brièvement l\'impro pour imposer une humeur au jouteur.', 'mixte' => false, 'comparee' => false],

            ['nom' => 'Poursuite', 'type' => 'Catégorie de structure', 'description' => 'Uniquement en comparée ; une équipe commence une improvisation que l\'autre équipe doit terminer.', 'mixte' => false, 'comparee' => true],
            ['nom' => 'Double-poursuite', 'type' => 'Catégorie de structure', 'description' => 'Uniquement en comparée ; une équipe commence une improvisation que l\'autre équipe doit terminer. La première équipe prend la suite de cette deuxième improvisation et la deuxième conclue. 4 improvisations seront jouées au final, constituant une seule et même histoire.', 'mixte' => false, 'comparee' => true],
            ['nom' => 'Roman-photo', 'type' => 'Catégorie de structure', 'description' => 'L\'improvisation est jouée en une succession de plans arrêtés (les photos) accompagnées de voix-off faisant parler les personnages.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Fusillade', 'type' => 'Catégorie de structure', 'description' => 'Lorsque l\'arbitre annonce cette catégorie, le nombre de joueurs demandé entre dans la patinoire, après quoi les joueurs font à tour de rôle une improvisation très courte sur un thème, différent pour chaque joueur, sans caucus.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Peau de chagrin', 'type' => 'Catégorie de structure', 'description' => 'Une même improvisation est jouée plusieurs fois, trois fois la plupart du temps, sur une durée à chaque fois plus courte (en général réduite de moitié).', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Exercice de style', 'type' => 'Catégorie de structure', 'description' => 'Les joueurs vont improviser 5 fois la même impro avec 5 styles imposés par l\'arbitre ou le maitre de cérémonie (généralement 5 fois une minute) ex : Péplum, Film d\'action, muette, film de Sciences Fictions, Cinéma d\'auteur...', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Zapping télé', 'type' => 'Catégorie de structure', 'description' => 'Des groupes de deux improvisateurs font chacun une chaîne ; l\'arbitre peut décider de zapper sur une autre chaîne/groupe.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Harold', 'type' => 'Catégorie de structure', 'description' => 'Tout le monde connaît et parle de Harold, mais personne ne le voit jamais sur scène.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Traveling', 'type' => 'Catégorie de structure', 'description' => 'Dès qu\'un personnage sort de scène, on le suit et l\'impro continue sur lui. Le traveling doit suivre chaque sortie de chacun.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Avec exagération', 'type' => 'Catégorie de structure', 'description' => 'Une même improvisation est jouée trois fois. À chaque fois, les improvisateurs doivent exagérer un peu plus leurs actions, leurs paroles, etc...', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Budget dégressif', 'type' => 'Catégorie de structure', 'description' => 'Une même improvisation, souvent de type film d\'action, est jouée deux ou trois fois, avec de moins en moins de budget. Par exemple, un hélicoptère sera remplacé par une moto puis par un vieux vélo, tandis que le jeu des acteurs sera de moins en moins bon.', 'mixte' => false, 'comparee' => false],
            ['nom' => '-1', 'type' => 'Catégorie de structure', 'description' => 'Une même improvisation est rejouée plusieurs fois, mais, à chaque fois, un joueur est retiré, de manière que les joueurs restants se retrouvent à prendre en charge plusieurs personnages en même temps, et ce jusqu\'à ce qu\'il ne reste qu\'un joueur qui doive rejouer toute l\'improvisation seul.', 'mixte' => false, 'comparee' => false],

            ['nom' => 'Ambiance musicale', 'type' => 'Catégorie par ajout', 'description' => 'Le musicien crée une ambiance musicale dont les joueurs doivent prendre compte, à la manière de la bande sonore d\'un film.', 'mixte' => false, 'comparee' => false],
            ['nom' => 'Accessoire', 'type' => 'Catégorie par ajout', 'description' => 'L\'arbitre donne un objet qui ne devra jamais être utilisé pour sa vraie fonction, et peut changer de fonction en cours d\'impro.', 'mixte' => false, 'comparee' => false],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};