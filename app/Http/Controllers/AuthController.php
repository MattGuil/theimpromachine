<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController
{
    /**
     * Afficher le formulaire d'inscription.
     */
    public function showRegister() {
        return view('auth.register');
    }

    /**
     * Afficher le formulaire de connexion.
     */
    public function showLogin() {
        return view('auth.login');
    }

    /**
     * Gérer le processus d'inscription.
     */
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create($validated);

        return redirect()->route('login');
    }

    /**
     * Gérer le processus de connexion.
     */
    public function login(LoginRequest $request) {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return to_route('login')->withErrors([
            'message' => 'Les identifiants renseignés sont incorrects.',
        ])->onlyInput('email');
    }

    /**
     * Gérer le processus de déconnexion.
     */
    public function logout(Request $request) {
        if ($request->isMethod('get')) {
            return redirect()->route('login');
        }
        
        Auth::logout();
        return redirect()->route('login');
    }
}