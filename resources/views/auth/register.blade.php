<x-layout>
    <h1 class="mb-4 text-center">Register</h1>

    <form action="{{ route('auth.register') }}" method="POST">
        @csrf

        <input class="form-control mb-4" placeholder="Name" type="text" name="name" value="{{ old('name') }}" required>
        <input class="form-control mb-4" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required>
        <input class="form-control mb-4" placeholder="Password" type="password" name="password" required>
        <input class="form-control mb-4" placeholder="Confirm password" type="password" name="password_confirmation" required>

        <button type="submit" class="btn btn-primary mt-4 w-100">Register</button>
        <a href="{{ route('login') }}" class="btn btn-outline-primary no-hover mt-2 w-100">Log in</a>
    
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger fixed-bottom mx-4">
                    {{ $error }}
                </p>
            @endforeach
        @endif
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alertMessages = document.querySelectorAll('.alert-danger');
            alertMessages.forEach(alertMessage => {
                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 3000);
            });
        });
    </script>
</x-layout>