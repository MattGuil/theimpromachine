<x-layout>
    <div id="home-container">
        <div class="d-flex align-items-center mb-3">
            <h2>Vos matchs</h2>
            <!-- Bouton pour créer un nouveau match -->
            <button id="newGameBtn" class="btn btn-light d-flex align-items-center ms-3">
                <i class="material-icons" style="font-size: 1.5rem;">add</i>
            </button>
        </div>
        @if ($games->isEmpty())
            <span id="no-games-message">Aucun match en stock pour le moment.</span>
        @else
            <table class="table" id="games-table">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="games-table-body">
                <!-- Matchs arbitrés par l'utilisateur connecté -->
                @foreach ($games as $game)
                    <tr id="game-{{ $game->id }}" class="game-row" data-id="{{ $game->id }}">
                        <td class="date">
                            <span>{{ $game->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td>
                            <span class="team-name">
                                {{ $game->equipe_1 }}
                                @if ($game->vainqueur == $game->equipe_1)
                                    <span class="material-symbols-outlined text-warning">crown</span>
                                @endif
                            </span>
                            /
                            <span class="team-name">
                                {{ $game->equipe_2 }}
                                @if ($game->vainqueur == $game->equipe_2)
                                    <span class="material-symbols-outlined text-warning">crown</span>
                                @endif
                            </span>
                        </td>
                        <td class="text-end">
                            <!-- Boutons pour jouer, voir ou supprimer un match -->
                            <button class="btn btn-success btn-sm play-game" data-id="{{ $game->id }}">
                                <i class="material-icons">play_arrow</i>
                            </button>
                            <button class="btn btn-info btn-sm view-game" data-id="{{ $game->id }}">
                                <i class="material-icons">visibility</i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-game" data-id="{{ $game->id }}" data-name="{{ $game->equipe_1 }}/{{ $game->equipe_2 }}">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modal de confirmation de suppression d'un match -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h6 class="modal-title" id="deleteModalLabel">Sûr de vouloir supprimer ce match ?</h6>
                </div>
                <div class="modal-body text-center" id="match-name"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" id="cancelDelete">Annuler</button>
                    <button class="btn btn-danger" id="confirmDelete">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour créer un nouveau match -->
    <div class="modal fade" id="newGameModal" tabindex="-1" role="dialog" aria-labelledby="newGameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newGameModalLabel">Générer un nouveau match</h5>
                </div>
                <div class="modal-body">
                    <form id="newGameForm">
                        <div class="d-flex justify-content-between gap-2">
                            <input type="text" placeholder="Nom de l'équipe 1" class="form-control" id="equipe_1" required>
                            <span class="d-flex align-items-center">VS.</span>
                            <input type="text" placeholder="Nom de l'équipe 2" class="form-control" id="equipe_2" required>
                        </div>
                        <br>
                        <label for="nb_joueurs">Nombre de joueurs par équipe</label>
                        <input type="number" class="form-control" id="nb_joueurs" min="2" max="10" value="7" required>
                        <br>
                        <label for="nb_joueurs">Nombre d'impros</label>
                        <input type="number" class="form-control" id="nb_impros" min="5" max="15" value="10" required>
                        <button type="submit" class="btn btn-primary w-100 mt-4" id="generateBtn">Générer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script type="text/javascript">
    $(document).ready(function() {
        var gameIdToDelete;

        // Afficher le modal pour créer un nouveau match
        $(document).on('click', '#newGameBtn', function(event) {
            event.stopPropagation();
            $('#newGameModal').modal('show');
        });

        // Rediriger vers la page de jeu pour jouer un match
        $(document).on('click', '.play-game', function(event) {
            event.stopPropagation();
            var gameId = $(this).data('id');
            window.location.href = '{{ url("play") }}/' + gameId;
        });
        
        // Rediriger vers la page de détails d'un match
        $(document).on('click', '.view-game', function(event) {
            event.stopPropagation();
            var gameId = $(this).data('id');
            window.location.href = '{{ url("game") }}/' + gameId;
        });

        // Rediriger vers la page de détails d'un match en cliquant sur une ligne de tableau
        $(document).on('click', '.game-row', function(event) {
            event.stopPropagation();
            var gameId = $(this).data('id');
            window.location.href = '{{ url("game") }}/' + gameId;
        });

        // Afficher le modal de confirmation de suppression d'un match
        $(document).on('click', '.delete-game', function(event) {
            event.stopPropagation();
            gameIdToDelete = $(this).data('id');
            var matchName = $(this).data('name');
            $('#match-name').text(matchName);
            $('#deleteModal').modal('show');
        });

        // Confirmer la suppression d'un match
        $('#confirmDelete').click(function() {
            $.ajax({
                url: '{{ url("deletegame") }}/' + gameIdToDelete,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    console.log(response);

                    // Supprimer la ligne du match supprimé
                    $('#game-' + gameIdToDelete).remove();
                    $('#deleteModal').modal('hide');
                    if ($('#games-table-body').children().length === 0) {
                        $('#games-table').remove();
                        $('#home-container').append('<span id="no-games-message">Aucun match en stock pour le moment.</span>');
                    }

                    // Afficher un message de confirmation de suppression
                    $('#home-container').prepend(
                        `<div id="alert-game-deleted" class="alert alert-danger fixed-bottom mx-4">Match ${response.game.equipe_1}/${response.game.equipe_2} supprimé !</div>`
                    );
                    setTimeout(() => {
                        $('#alert-game-deleted').fadeOut();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                    console.log(xhr.responseText);
                }
            });
        });

        // Annuler la suppression d'un match
        $('#cancelDelete').click(function() {
            gameIdToDelete = null;
            $('#deleteModal').modal('hide');
        });

        // Soumettre le formulaire pour générer un nouveau match
        $('#newGameForm').submit(function(event) {
            event.preventDefault();
            var generateBtn = $('#generateBtn');
            console.log(generateBtn);
            generateBtn.html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span class="visually-hidden" role="status">Loading...</span>  ');
            generateBtn.prop('disabled', true);

            if (equipe_1 && equipe_2 && nb_joueurs && nb_impros) {
                $.ajax({
                    url: '{{ url("generategame") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        arbitre: '{{ Auth::user()->name }}',
                        equipe_1: $('#equipe_1').val(),
                        equipe_2: $('#equipe_2').val(),
                        nb_joueurs: $('#nb_joueurs').val() * 2,
                        nb_impros: $('#nb_impros').val(),
                    },
                    success: function(response) {
                        console.log(response);
                        var newRow = `
                            <tr id="game-${response.game.id}" class="game-row" data-id="${response.game.id}">
                                <td class="date">
                                    <span>${new Date(response.game.created_at).toLocaleDateString()}</span>
                                </td>
                                <td>
                                    <span>${response.game.equipe_1}</span>
                                    ${response.game.vainqueur == response.game.equipe_1 ? '<span class="material-symbols-outlined text-warning">crown</span>' : ''}
                                    / 
                                    <span>${response.game.equipe_2}</span>
                                    ${response.game.vainqueur == response.game.equipe_2 ? '<span class="material-symbols-outlined text-warning">crown</span>' : ''}
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-success btn-sm play-game" data-id="${response.game.id}">
                                        <i class="material-icons">play_arrow</i>
                                    </button>
                                    <button class="btn btn-info btn-sm view-game" data-id="${response.game.id}">
                                        <i class="material-icons">visibility</i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-game" data-id="${response.game.id}" data-name="${response.game.equipe_1} / ${response.game.equipe_2}">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        if ($('#games-table-body').length === 0) {
                            $('#no-games-message').remove();
                            $('#home-container').append(`
                                <table class="table" id="games-table">
                                    <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="games-table-body">
                                        ${newRow}
                                    </tbody>
                                </table>
                            `);
                        } else {
                            $('#games-table-body').append(newRow);
                        }

                        // Afficher un message de confirmation de création
                        $('#home-container').prepend(
                            `<div id="alert-game-created" class="alert alert-success fixed-bottom mx-4">Nouveau match ${response.game.equipe_1}/${response.game.equipe_2} disponible !</div>`
                        );
                        setTimeout(() => {
                            $('#alert-game-created').fadeOut();
                        }, 3000);

                        $('#newGameForm')[0].reset();
                        $('#newGameModal').modal('hide');
                        generateBtn.html('Générer');
                        generateBtn.prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                        console.log(xhr.responseText);
                        generateBtn.html('Générer');
                        generateBtn.prop('disabled', false);
                    }
                });
            }
        });
    });
</script>