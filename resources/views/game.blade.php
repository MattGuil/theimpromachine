<x-layout>
    <div id="game-container">
        <h2>{{ $game->equipe_1 }} / {{ $game->equipe_2 }}</h2>
        <table class="table mt-4">
            <thead class="opacity-50">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Type</th>
                    <th scope="col">Nombre de joueurs</th>
                    <th scope="col">Durée</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Thème</th>
                    <th scope="col">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($impros as $impro)
                    <tr data-id="{{ $impro->id }}">
                        <td>{{ $impro->id }}</td>
                        <td>{{ $impro->type }}</td>
                        <td>{{ $impro->nb_joueur }}</td>
                        <td>{{ $impro->duree }} minutes</td>
                        <td>{{ $impro->categorie_id }}</td>
                        <td>{{ $impro->theme }}</td>
                        <td>{{ $impro->statut }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between gap-2 mt-4">
            <button id="save-order" class="btn btn-primary w-50">Enregistrer</button>
            <button id="play-game" class="btn btn-success w-50">Jouer</button>
        </div>
    </div>
</x-layout>

<script type="text/javascript">
    $(document).ready(function() {

        $.ajax({
            url: '{{ url("createimpro") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                game_id: '{{ $game->id }}',
                position: 1000,
                type: 'Mixte',
                nb_joueur: 4,
                duree: 10,
                categorie_id: 1,
                theme: 'Thème exemple',
                statut: 'Créée'
            },
            success: function(response) {
                console.log(response);
                var newRow = `
                    <tr data-id="${response.impro.id}">
                        <td>${response.impro.id}</td>
                        <td>${response.impro.type}</td>
                        <td>${response.impro.nb_joueur}</td>
                        <td>${response.impro.duree} minutes</td>
                        <td>${response.impro.categorie_id}</td>
                        <td>${response.impro.theme}</td>
                        <td>${response.impro.statut}</td>
                    </tr>
                `;
                $('tbody').append(newRow);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
                console.log(xhr.responseText);
            }
        });

        var tbody = document.querySelector('tbody');

        new Sortable(tbody, {
            animation: 150,
            ghostClass: 'bg-light'
        });

        $('#save-order').click(function() {
            var order = [];
            $('tbody tr').each(function(index, element) {
                order.push({
                    id: $(element).data('id'),
                    position: index + 1
                });
            });

            $.ajax({
                url: '{{ url("updateimprosorder") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order: order
                },
                success: function(response) {
                    console.log('Order saved successfully!');
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    console.log(xhr.responseText);
                }
            });
        });

        $('#play-game').click(function() {
            window.location.href = '{{ url("play") }}/' + {{ $game->id }};
        });
    });
</script>