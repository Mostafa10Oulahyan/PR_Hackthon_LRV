@extends('layouts.app')

@section('title', 'Mon Profil - BiblioTech')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-4">
    <!-- Sidebar / Overview -->
    <div class="glass-card rounded-2xl p-6 sm:p-8 flex flex-col items-center text-center shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>
        
        <div class="relative mb-4 mt-4">
            <!-- Rotating dashed ring -->
            <div class="absolute -top-1.5 -left-1.5 -right-1.5 -bottom-1.5 rounded-full border-2 border-dashed border-teal-500/40 animate-[spin_20s_linear_infinite]"></div>
            <img src="{{ asset($user->image_profile ?? 'images/user_avatar.png') }}" class="w-24 h-24 rounded-full border border-white/20 object-cover shadow-lg shadow-indigo-500/25" alt="Avatar">
        </div>
        
        <form action="{{ route('membre.profil.update_avatar') }}" method="POST" enctype="multipart/form-data" class="mb-6 w-full flex justify-center">
            @csrf
            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="this.form.submit()">
            <label for="avatar" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-indigo-500/10 hover:bg-indigo-500 hover:text-white border border-indigo-500/25 transition-all duration-200 cursor-pointer">
                Changer l'avatar
            </label>
        </form>
        
        <h2 class="text-xl font-bold text-white mb-1">{{ $user->name }}</h2>
        <span class="text-[10px] font-bold tracking-wider px-2.5 py-0.5 rounded-full uppercase bg-teal-500/10 text-teal-400 border border-teal-500/20 mb-6">
            {{ $user->role }}
        </span>
        
        <div class="w-full space-y-4 text-sm">
            <div class="flex justify-between py-2.5 border-b border-white/5">
                <span class="text-gray-400">E-mail</span>
                <span class="font-medium text-white">{{ $user->email }}</span>
            </div>
            <div class="flex justify-between py-2.5 border-b border-white/5">
                <span class="text-gray-400">Membre depuis</span>
                <span class="font-medium text-white">{{ $user->created_at ? $user->created_at->format('d/m/Y') : date('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between py-2.5">
                <span class="text-gray-400">Statut compte</span>
                <span class="font-medium text-emerald-400">Actif</span>
            </div>
        </div>
    </div>

    <!-- Main Profile Content -->
    <div class="md:col-span-2 flex flex-col gap-8">
        <!-- Statistics Section -->
        <div class="glass-card rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-[3px] bg-indigo-500/30"></div>
            <h3 class="text-lg font-outfit font-bold flex items-center gap-2 mb-6 text-white">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Mes statistiques de lecture
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white/[0.02] border border-white/5 rounded-xl p-5 hover:border-indigo-500/20 transition-all duration-200">
                    <div class="text-3xl font-extrabold text-white mb-1">{{ $totalEmprunts }}</div>
                    <div class="text-xs text-gray-400 font-medium">Livres empruntés</div>
                </div>
                <div class="bg-white/[0.02] border border-white/5 rounded-xl p-5 hover:border-indigo-500/20 transition-all duration-200">
                    <div class="text-3xl font-extrabold text-white mb-1">{{ $empruntsEnCours }}</div>
                    <div class="text-xs text-gray-400 font-medium">Emprunts actifs</div>
                </div>
                <div class="bg-white/[0.02] border border-white/5 rounded-xl p-5 hover:border-indigo-500/20 transition-all duration-200">
                    <div class="text-3xl font-extrabold text-white mb-1">
                        @if($totalEmprunts > 0)
                            {{ round(($empruntsEnCours / $totalEmprunts) * 100) }}%
                        @else
                            0%
                        @endif
                    </div>
                    <div class="text-xs text-gray-400 font-medium">Taux d'activité</div>
                </div>
            </div>
        </div>

        <!-- Security / Info Section -->
        <div class="glass-card rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-[3px] bg-teal-500/30"></div>
            <h3 class="text-lg font-outfit font-bold flex items-center gap-2 mb-4 text-white">
                <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Sécurité & Confidentialité
            </h3>
            <p class="text-gray-400 text-sm leading-relaxed mb-6">
                Votre mot de passe est chiffré et stocké de manière sécurisée dans nos serveurs de base de données.
                Pour modifier vos informations personnelles ou réinitialiser votre mot de passe, veuillez contacter l'administrateur de BiblioTech Cloud.
            </p>
            <div class="flex items-center gap-4 flex-wrap">
                <a href="mailto:admin@bibliotech.cloud" class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow shadow-indigo-500/10 transition-all duration-200 cursor-pointer">Contacter le support</a>
                <a href="{{ route('membre.dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-gray-300 bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-200 cursor-pointer">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>
@endsection
