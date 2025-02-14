<x-layout>
    <div id="home-container">
        <h2>Vos matchs</h2>
        <table class="table">
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
                    <td class="align-middle">
                        <button class="btn btn-info btn-sm view-game" data-id="{{ $game->id }}">
                            <i class="material-icons">visibility</i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-game" data-id="{{ $game->id }}">
                            <i class="material-icons">delete</i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            url: '{{ url("creategame") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                arbitre: '{{ Auth::user()->name }}',
                equipe_1: 'Les Zozos',
                equipe_2: 'Les Zinzins',
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
                        <td class="align-middle">
                            <button class="btn btn-info btn-sm view-game" data-id="${response.game.id}">
                                <i class="material-icons">visibility</i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-game" data-id="${response.game.id}">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#games-table-body').append(newRow);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
                console.log(xhr.responseText);
            }
        });

        $(document).on('click', '.view-game', function() {
            var gameId = $(this).data('id');
            window.location.href = '{{ url("game") }}/' + gameId;
        });

        $(document).on('click', '.game-row', function() {
            var gameId = $(this).data('id');
            window.location.href = '{{ url("game") }}/' + gameId;
        });

        $(document).on('click', '.delete-game', function(event) {
            event.stopPropagation();
            var gameId = $(this).data('id');

            if (confirm('Êtes-vous sûr de vouloir supprimer ce match ?')) {
                $.ajax({
                    url: '{{ url("deletegame") }}/' + gameId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        console.log(response);
                        $('#game-' + gameId).remove();
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
    $('#newGameBtn').click(function() {
        var equipe_1 = $('#equipe_1').val();
        var equipe_2 = $('#equipe_2').val();
        var equipe_1_score = $('#equipe_1_score').val();
        var equipe_2_score = $('#equipe_2_score').val();
        var statut = $('#statut').val();

        $.ajax({
            url: '{{ url("newgame") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                equipe_1: equipe_1,
                equipe_2: equipe_2,
                equipe_1_score: equipe_1_score,
                equipe_2_score: equipe_2_score,
                statut: statut
            },
            success: function(response) {
                alert('New Game created successfully!');
                console.log(response);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    });

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