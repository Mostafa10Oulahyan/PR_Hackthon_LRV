@extends('layouts.app')

@section('title', 'Mot de passe oublié - BiblioTech')

@section('content')
<div class="max-w-md mx-auto my-8 sm:my-16">
    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-white transition-colors duration-200 mb-6 group">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Retour à la connexion
    </a>

    <div class="glass-card rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
        <!-- Top decorative border line -->
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>

        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-16 w-auto mx-auto mb-6 filter drop-shadow-[0_0_10px_rgba(99,102,241,0.5)]">
        <h2 class="text-2xl font-outfit font-bold text-center mb-4 bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">Mot de passe oublié ?</h2>
        <p class="text-sm text-gray-400 text-center mb-6 leading-relaxed">
            Saisissez l'adresse e-mail de votre compte de bibliothèque. Nous vérifierons votre identité pour vous permettre de définir un nouveau mot de passe.
        </p>
        
        <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-400 mb-1.5">Adresse E-mail</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('email') }}" required autofocus placeholder="Ex: jean.dupont@email.com">
            </div>
            
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md hover:shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer mt-4">
                Identifier mon compte
            </button>
        </form>
    </div>
</div>
@endsection
