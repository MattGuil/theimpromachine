<x-layout>
    <!--
    <div class="w-100">
        <form id="add-post">
            @csrf
            <input class="form-control mb-4" placeholder="Title"  type="text" name="title">
            <input class="form-control mb-4" placeholder="Description"  type="text" name="description">
            <button type="submit" class="btn btn-primary w-100">Add</button>
        </form>
    </div>
    <div id="post-list" class="d-grid gap-2">
        @foreach ($posts as $post)
            <p>{{ $post->title }}</p>
        @endforeach
    </div>
    -->

    <div id="home-container" class="w-50">
        <div id="new-game-form">
            <input class="form-control mb-2" type="text" id="equipe_1" value="Les Winners">
            <input class="form-control mb-2" type="text" id="equipe_2" value="Les Losers">
            <input class="form-control mb-2" type="number" id="equipe_1_score" value="0">
            <input class="form-control mb-2" type="number" id="equipe_2_score" value="0">
            <input class="form-control mb-2" type="text" id="statut" value="Créée">
    
            <button class="btn btn-primary" id="newGameBtn">New Game</button>
        </div>
    
        <div id="new-impro-form">
            <input class="form-control mb-2" type="text" id="game_id" value="1">
            <input class="form-control mb-2" type="text" id="type" value="Mixte">
            <input class="form-control mb-2" type="number" id="nb_joueur" value="5">
            <input class="form-control mb-2" type="number" id="duree" value="30">
            <input class="form-control mb-2" type="text" id="categorie_id" value="2">
            <input class="form-control mb-2" type="text" id="theme" value="Thematic theme">
            <input class="form-control mb-2" type="text" id="statut" value="Créée">
    
            <button class="btn btn-primary" id="newImproBtn">New Impro</button>
        </div>
    </div>
</x-layout>

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
    */

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
</script>

<style>
    #home-container {
        margin: auto;
        display: flex;
        justify-content: space-around;
    }

    #new-game-form, #new-impro-form {
        display: flex;
        flex-direction: column;
        margin: 10px 0;
    }
</style>