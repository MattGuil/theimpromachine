<x-layout>
    <div id="play-container">
        <div id="improCarousel" class="carousel slide">
            <div class="carousel-inner">
                @foreach ($impros as $index => $impro)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="d-flex flex-column align-items-center p-3">
                            <h3 class="mb-3">Improvisation {{ $index + 1 }}/{{ count($impros) }}</h3>
                            <div class="w-100">
                                <div class="attribut-container">
                                    <span class="attribut-label">Type</span>
                                    <p class="attribut-value">{{ $impro->type }}</p>
                                </div>
                                <div class="attribut-container">
                                    <span class="attribut-label">Joueurs</span>
                                    <p class="attribut-value">{{ $impro->nb_joueurs == -1 ? 'Illimité' : $impro->nb_joueurs }}</p>
                                </div>
                                <div class="attribut-container">
                                    <span class="attribut-label">Durée</span>
                                    <p>{{ gmdate('H:i:s', $impro->duree * 60) }}</p>
                                </div>
                                <div class="attribut-container">
                                    <span class="attribut-label">Catégorie</span>
                                    <p class="attribut-value">{{ $impro->categorie->nom }}</p>
                                </div>
                                <div class="attribut-container">
                                    <span class="attribut-label">Thème</span>
                                    <p class="attribut-value">{{ $impro->theme }}</p>
                                </div>
                                <div class="btn-group mt-3 w-100 equal-width-buttons" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradio-{{ $index }}" id="btnradio-{{ $index }}-1" autocomplete="off" data-impro-id="{{ $impro->id }}" value="{{ $game->equipe_1 }}">
                                    <label class="btn btn-outline-warning" for="btnradio-{{ $index }}-1">{{ $game->equipe_1 }}</label>
                                    
                                    <input type="radio" class="btn-check" name="btnradio-{{ $index }}" id="btnradio-{{ $index }}-3" autocomplete="off" data-impro-id="{{ $impro->id }}" value="{{ $game->equipe_2 }}">
                                    <label class="btn btn-outline-warning" for="btnradio-{{ $index }}-3">{{ $game->equipe_2 }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="carousel-item">
                    <div class="d-flex flex-column align-items-center p-3">
                        <h3 class="mb-3">Match Terminé</h3>
                        <p id="winning-team"></p>
                        <h4>Bilan</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Équipe</th>
                                    <th scope="col">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $game->equipe_1 }}</td>
                                    <td id="score-team-1"></td>
                                </tr>
                                <tr>
                                    <td>{{ $game->equipe_2 }}</td>
                                    <td id="score-team-2"></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Retour à l'accueil</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#improCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</x-layout>

<script type="text/javascript">

    $(document).ready(function() {
        resetGame({{ $game->id }});
    });

    var myCarousel = document.querySelector('#improCarousel');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: false,
        wrap: false
    });

    const carouselInner = document.querySelector('.carousel-inner');
    const carouselItems = carouselInner.querySelectorAll('.carousel-item');

    carouselItems.forEach(function(item, index) {
        item.querySelectorAll('.btn-check').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (radio.checked) {
                    updateWinner(radio.dataset.improId, radio.value);
                }
            });
        });
    });

    const prevButton = document.querySelector('.carousel-control-prev');
    prevButton.addEventListener('click', function() {
        carousel.prev();
    });

    const nextButton = document.querySelector('.carousel-control-next');
    nextButton.addEventListener('click', function() {
        const activeIndex = Array.from(carouselItems).findIndex(item => item.classList.contains('active'));
        const nextIndex = activeIndex + 1;

        if (nextIndex < carouselItems.length) {
            const currentImproId = carouselItems[activeIndex].querySelector('.btn-check').dataset.improId;

            $.ajax({
                url: '{{ url("hasimprowinner") }}/' + currentImproId,
                method: 'GET',
                success: function(response) {
                    if (response.has_winner) {
                        carousel.next();
                    } else {
                        const nextImproId = carouselItems[nextIndex].querySelector('.btn-check').dataset.improId;
                        $.ajax({
                            url: '{{ url("hasimprowinner") }}/' + nextImproId,
                            method: 'GET',
                            success: function(response) {
                                if (response.has_winner) {
                                    carousel.next();
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log('Error: ' + error);
                                console.log(xhr.responseText);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    console.log(xhr.responseText);
                }
            });
        }
    });

    function resetGame(gameId) {
        $.ajax({
            url: '{{ url("resetgame") }}/' + gameId,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Game reset successfully!');
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    }

    function updateWinner(improId, winner) {
        $.ajax({
            url: '{{ url("updateimprowinner") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                impro_id: improId,
                winner: winner
            },
            success: function(response) {
                console.log('Winner updated successfully!');
                if (carouselItems.length - 2 === Array.from(carouselItems).findIndex(item => item.classList.contains('active'))) {
                    displayFinalResults();
                } else {
                    carousel.next();
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    }

    function displayFinalResults() {
        // Appel à updateGameWinner pour mettre à jour le vainqueur du jeu
        $.ajax({
            url: '{{ url("updategamewinner") }}/{{ $game->id }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Game winner updated successfully!');

                // Ensuite, appel à getGameResults pour obtenir les résultats du jeu
                $.ajax({
                    url: '{{ url("gameresults") }}/{{ $game->id }}',
                    method: 'GET',
                    success: function(response) {
                        response.winner == '=' ?
                            document.getElementById('winning-team').textContent = 'Égalité !' :
                            document.getElementById('winning-team').textContent = 'L\'équipe ' + response.winner + ' l\'emporte !';
                        document.getElementById('score-team-1').textContent = response.score_team_1;
                        document.getElementById('score-team-2').textContent = response.score_team_2;
                        carousel.next();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error);
                        console.log(xhr.responseText);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
                console.log(xhr.responseText);
            }
        });
    }
</script>