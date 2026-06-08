@extends('layouts.app')

@section('title', 'Inscription - BiblioTech Cloud')

@section('content')
<div class="max-w-md mx-auto my-6 sm:my-12">
    <div class="glass-card rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
        <!-- Top decorative border line -->
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>

        <img src="{{ asset('images/Logo_large.png') }}" alt="Logo" class="h-12 w-auto mx-auto mb-6 filter drop-shadow-[0_0_10px_rgba(99,102,241,0.5)]">
        <h2 class="text-2xl font-outfit font-bold text-center mb-8 bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">Créer un compte membre</h2>
        
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-400 mb-1.5">Nom complet</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('name') }}" required autofocus placeholder="Ex: Jean Dupont">
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-400 mb-1.5">Adresse E-mail</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('email') }}" required placeholder="Ex: jean.dupont@email.com">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-400 mb-1.5">Mot de passe (min. 6 caractères)</label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full pl-4 pr-10 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" required placeholder="••••••••">
                    <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors duration-150 focus:outline-none cursor-pointer">
                        <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-400 mb-1.5">Confirmer le mot de passe</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full pl-4 pr-10 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" required placeholder="••••••••">
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors duration-150 focus:outline-none cursor-pointer">
                        <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.43 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md hover:shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer mt-4">
                S'inscrire
            </button>
        </form>
        
        <div class="text-center mt-6 text-sm text-gray-400">
            Déjà inscrit ? <a href="{{ route('login') }}" class="text-indigo-400 hover:underline font-semibold transition-colors duration-200">Se connecter</a>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeOpen = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>
@endsection
