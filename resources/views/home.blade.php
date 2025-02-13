<x-layout>
    <div id="home-container">
        <h2>Vos matchs</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Équipe 1</th>
                <th scope="col">Équipe 2</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($games as $game)
                <tr>
                    <th scope="row">{{ $game->id }}</th>
                    <td>
                        {{ $game->equipe_1 }}
                        @if ($game->statut == "Terminé")
                            ({{ $game->equipe_1_score }})
                        @endif
                    </td>
                    <td>
                        {{ $game->equipe_2 }}
                        @if ($game->statut == "Terminé")
                            ({{ $game->equipe_2_score }})
                        @endif
                    </td>
                    <td>
                        <i class="material-icons">visibility</i>
                        <i class="material-icons">replay</i>
                        <i class="material-icons">delete</i>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>

<!-- Import Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<script type="text/javascript">
    /*
    $(document).ready(function() {
        $('#add-post').on('submit', function(event) {
            event.preventDefault();
            jQuery.ajax({
                type: 'POST',
                url: "{{ url('newpost') }}",
                data: jQuery('#add-post').serialize(),

                success: function(result) {
                    console.log(result);
                    if (result.status === 200) {
                        // $('#post-list').append(`<p>${result.post.title}</p>`);
                        $('#add-post')[0].reset();
                    } else {
                        console.error('Une erreur est survenue.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erreur:', error);
                }
            });
        });
    });

    $(document).ready(function() {
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
    });
    */
</script>

<style>
    #home-container {
        padding: 20px;
    }
</style>