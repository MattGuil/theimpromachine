<x-layout>
    <div id="help-container">
        <h2>Qu'est-ce que l'improvisation théâtrale ?</h2>
        <p class="small-paragraph">Le spectacle d'improvisation est une création théâtrale sans texte préécrit.</p>
        <p class="small-paragraph">Lors de ces spectacles généralement interactifs, une catégorie (<a href="#categories-dictionary">cf. Dictionnaire des catégories</a>) et un thème sont proposés aux comédiens et comédiennes (par le public ou par un tiers). Ces derniers et dernières improvisent alors ensemble pendant une durée variant de quelques secondes à plus d'une heure en construisant une histoire, des personnages, des décors à partir de cette catégorie (s'il y a) et de ce thème de départ.</p>
        <p class="small-paragraph">L'objectif pour les comédiens improvisateurs et comédiennes improvisatrices est de jouer ensemble en intégrant positivement chaque idée proposée par ses partenaires. Ceci par le biais de différentes règles de jeu qui sont celles du théâtre en général mais dans l'instant et, généralement, sans période de réflexion.</p>
        <p class="small-paragraph">Une ou plusieurs improvisations peuvent s'enchaîner pour créer un spectacle complet.</p>
        <h2>The Impro Machine</h2>
        <p class="small-paragraph"><span class="fst-italic">The Impro Machine</span> vous permet de générer des matchs d'improvisation automatiquement et facilement !</p>
        <h2 id="categories-dictionary">Dictionnaire des catégories</h2>
        <div class="accordion" id="categoriesAccordion">
            @foreach ($categories as $type => $categoriesByType)
                @if ($type != '')
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="heading-{{ Str::slug($type) }}">
                            <button class="accordion-button no-hover" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ Str::slug($type) }}" aria-expanded="true" aria-controls="collapse-{{ Str::slug($type) }}">
                                {{ $type }}
                            </button>
                        </h3>
                        <div id="collapse-{{ Str::slug($type) }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ Str::slug($type) }}" data-bs-parent="#categoriesAccordion">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categoriesByType as $categorie)
                                            @if ($categorie->description != '')
                                                <tr>
                                                    <td class="small-heading">{{ $categorie->nom }}</td>
                                                    <td class="small-paragraph">{{ $categorie->description }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-layout>
