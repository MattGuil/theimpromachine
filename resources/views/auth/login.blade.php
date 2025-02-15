<x-layout>
    <div id="login-container">

        <h2 class="text-center">Connexion</h2>

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf

            <input class="form-control mt-4" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required>
            
            <input class="form-control mt-4" placeholder="Mot de passe" type="password" name="password" required>
            
            <button type="submit" class="btn btn-primary mt-4 w-100">Me connecter</button>
            <a href="{{ route('register') }}" class="btn btn-outline-secondary no-hover mt-2 w-100">Me créer un compte</a>
        
            @error("message")
            <div id="alert-message" class="alert alert-danger fixed-bottom mx-4">
                {{ $message }}
            </div>
            @enderror
        </form>
    </div>
</x-layout>

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