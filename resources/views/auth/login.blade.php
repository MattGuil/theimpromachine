<x-layout>
    <h1 class="text-center">Login</h1>

    <form action="{{ route('auth.login') }}" method="POST">
        @csrf

        <input class="form-control mt-4" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required>
        
        <input class="form-control mt-4" placeholder="Password" type="password" name="password" required>
        
        <button type="submit" class="btn btn-primary mt-4 w-100">Log in</button>
        <a href="{{ route('register') }}" class="btn btn-outline-primary no-hover mt-2 w-100">Register</a>
    </form>

    @error("message")
    <p id="alert-message" class="alert alert-danger fixed-bottom mx-4">
        {{ $message }}
    </p>
    @enderror

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</x-layout>