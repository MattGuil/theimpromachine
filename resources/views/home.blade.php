<x-layout>
    <div id="home-container">
        <div class="d-flex align-items-center mb-3">
            <h2>Vos matchs</h2>
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
                @foreach ($games as $game)
                    <tr id="game-{{ $game->id }}" class="game-row" data-id="{{ $game->id }}">
                        <td>{{ $game->equipe_1 }} / {{ $game->equipe_2 }}</td>
                        <td>{{ $game->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <button class="btn btn-success btn-sm play-game" data-id="{{ $game->id }}">
                                <i class="material-icons">play_arrow</i>
                            </button>
                            <button class="btn btn-info btn-sm view-game" data-id="{{ $game->id }}">
                                <i class="material-icons">visibility</i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-game" data-id="{{ $game->id }}" data-name="{{ $game->equipe_1 }} / {{ $game->equipe_2 }}">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="deleteModalLabel">Sûr de vouloir supprimer ce match ?</h5>
                </div>
                <div class="modal-body text-center" id="match-name"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" id="cancelDelete">Annuler</button>
                    <button class="btn btn-danger" id="confirmDelete">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script type="text/javascript">
    $(document).ready(function() {
        var gameIdToDelete;

        $(document).on('click', '.play-game', function(event) {
            event.stopPropagation();
            var gameId = $(this).data('id');
            window.location.href = '{{ url("play") }}/' + gameId;
        });
        
        $(document).on('click', '.view-game', function(event) {
            event.stopPropagation();
            var gameId = $(this).data('id');
            window.location.href = '{{ url("game") }}/' + gameId;
        });

        $(document).on('click', '.game-row', function(event) {
            event.stopPropagation();
            var gameId = $(this).data('id');
            window.location.href = '{{ url("game") }}/' + gameId;
        });

        $(document).on('click', '.delete-game', function(event) {
            event.stopPropagation();
            gameIdToDelete = $(this).data('id');
            var matchName = $(this).data('name');
            $('#match-name').text(matchName);
            $('#deleteModal').modal('show');
        });

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
                    $('#game-' + gameIdToDelete).remove();
                    $('#deleteModal').modal('hide');
                    if ($('#games-table-body').children().length === 0) {
                        $('#games-table').remove();
                        $('#home-container').append('<span id="no-games-message">Aucun match en stock pour le moment.</span>');
                    }

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

        $('#cancelDelete').click(function() {
            gameIdToDelete = null;
            $('#deleteModal').modal('hide');
        });

        $('#newGameBtn').click(function() {
            var equipe_1 = prompt("Nom de l'équipe 1:");
            var equipe_2 = prompt("Nom de l'équipe 2:");
            if (equipe_1 && equipe_2) {
                $.ajax({
                    url: '{{ url("creategame") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        arbitre: '{{ Auth::user()->name }}',
                        equipe_1: equipe_1,
                        equipe_2: equipe_2,
                        equipe_1_score: null,
                        equipe_2_score: null,
                        statut: 'Créée',
                        vainqueur: null
                    },
                    success: function(response) {
                        console.log(response);
                        var newRow = `
                            <tr id="game-${response.game.id}" class="game-row" data-id="${response.game.id}">
                                <td>${response.game.equipe_1} / ${response.game.equipe_2}</td>
                                <td>${new Date(response.game.created_at).toLocaleDateString()}</td>
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

                        $('#home-container').prepend(
                            `<div id="alert-game-created" class="alert alert-success fixed-bottom mx-4">Nouveau match ${response.game.equipe_1}/${response.game.equipe_2} disponible !</div>`
                        );
                        setTimeout(() => {
                            $('#alert-game-created').fadeOut();
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });

    /*
    $('#newImproBtn').click(function() {
        var game_id = $('#game_id').val();
        var type = $('#type').val();
        var nb_joueur = $('#nb_joueur').val();
        var duree = $('#duree').val();
        var categorie_id = $('#categorie_id').val();
        var theme = $('#theme').val();
        var statut = $('#statut').val();

        $.ajax({
            url: '{{ url("newimpro") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                game_id: game_id,
                type: type,
                nb_joueur: nb_joueur,
                duree: duree,
                categorie_id: categorie_id,
                theme: theme,
                statut: statut
            },
            success: function(response) {
                alert('New Impro created successfully!');
                console.log(response);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    });
    */
</script>