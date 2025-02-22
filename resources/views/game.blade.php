<x-layout>
    <div id="game-container">
        <!-- Affiche les noms des 2 équipes qui s'affrontent -->
        <h2>{{ $game->equipe_1 }} / {{ $game->equipe_2 }}</h2>
        <h4>Liste ordonnée des improvisations du match</h4>
        <table class="table mt-4">
            <caption>PS : L'ordre des improvisations est modifiable par drag and drop.</caption>
            <thead class="opacity-50">
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">Joueurs</th>
                    <th scope="col">Durée</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Thème</th>
                </tr>
            </thead>
            <tbody>
                <!-- Détails des improvisations -->
                @foreach ($impros as $impro)
                    <tr data-id="{{ $impro->id }}">
                        <td>{{ $impro->type }}</td>
                        <td>{{ $impro->nb_joueurs == -1 ? 'Illimité' : $impro->nb_joueurs }}</td>
                        <td>{{ $impro->duree }} min</td>
                        <td>
                            {{ $impro->categorie->nom }}
                            <!-- Icône d'information à survoler avec le curseur pour connaître la description de la catégorie -->
                            @if ($impro->categorie->description != '')
                                <i class="material-icons opacity-50" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $impro->categorie->description }}">info</i>
                            @endif
                        </td>
                        <td>{{ $impro->theme }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between gap-2 mt-4">
            <!-- Bouton pour enregistrer l'ordre des improvisations -->
            <button id="save-order" class="btn btn-primary w-50">Enregistrer</button>
            <!-- Bouton pour jouer le match -->
            <button id="play-game" class="btn btn-success w-50">Jouer</button>
        </div>
    </div>
</x-layout>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialisation de la fonctionnalité de drag and drop pour réorganiser les improvisations
        var tbody = document.querySelector('tbody');

        new Sortable(tbody, {
            animation: 150,
            ghostClass: 'bg-light'
        });

        // Gestionnaire d'événement pour le bouton "Enregistrer"
        $('#save-order').click(function() {
            var order = [];
            $('tbody tr').each(function(index, element) {
                order.push({
                    id: $(element).data('id'),
                    position: index + 1
                });
            });

            // Envoi du nouvel ordre des improvisations au serveur
            $.ajax({
                url: '{{ url("updateimprosorder") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order: order
                },
                success: function(response) {
                    console.log('Order saved successfully!');
                    // Affiche un message de succès
                    $('#game-container').prepend(
                        `<div id="alert-message" class="alert alert-info fixed-bottom mx-4">Ordre des improvisations mis à jour !</div>`
                    );
                    setTimeout(() => {
                        $('#alert-message').fadeOut();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    console.log(xhr.responseText);
                }
            });
        });

        // Gestionnaire d'événement pour le bouton "Jouer"
        $('#play-game').click(function() {
            window.location.href = '{{ url("play") }}/' + {{ $game->id }};
        });

        // Initialisation des tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>