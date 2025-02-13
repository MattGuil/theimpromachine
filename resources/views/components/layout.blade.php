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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    @auth
    <header>
        <nav>
            <h1>The Impro Machine</h1>
            <div>
                {{ \Illuminate\Support\Facades\Auth::user()->name }}
                <form class="ms-2" action="{{ route('auth.logout') }}" method="POST" id="logout-form">
                    @method("delete")
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </nav>
    </header>
    @endauth

    <main>
        {{ $slot }}
    </main>

    <style>
        nav {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav h1 {
            margin: 0;
        }

        nav div {
            display: flex;
            align-items: center;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>