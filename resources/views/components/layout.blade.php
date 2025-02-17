<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ config('app.name') }}</title>
    @vite('resources/sass/app.scss')
    @vite('resources/js/app.js')
</head>
<body>

    @if (!request()->routeIs('login') && !request()->routeIs('register'))
    <header class="fixed-top">
        <nav>
            <div class="logo-container" style="cursor: pointer;">
                <img src="{{ asset('images/theatre.png') }}" alt="The Impro Machine Logo">
                <h1>The Impro Machine</h1>
            </div>
            <div class="ms-2">
                <a href="{{ route('help') }}" class="btn btn-outline-secondary">Aide</a>
                <form action="{{ route('auth.logout') }}" method="POST" id="logout-form" class="d-inline">
                    @method("delete")
                    @csrf
                    <button type="submit" class="btn">{{ \Illuminate\Support\Facades\Auth::user()->name }} <i class="material-icons">logout</i></button>
                </form>
            </div>
        </nav>
    </header>
    @endif

    <main>
        {{ $slot }}
    </main>

    @if (!request()->routeIs('login') && !request()->routeIs('register'))
    <footer class="opacity-50">
        © 2025 The Impro Machine - Matthieu Guillemin.
    </footer>
    @endif

    @if (!request()->routeIs('login') && !request()->routeIs('register'))
    <script>
        document.querySelector('.logo-container').addEventListener('click', function() {
            window.location.href = '{{ route('home') }}';
        });
    </script>
    @endif

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>