@extends('layouts.app')

@section('title', 'Mon Espace - BiblioTech')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Bonjour, {{ $user->name }}</h1>
        <p class="text-gray-400 text-sm mt-1">Bienvenue dans votre espace membre BiblioTech.</p>
    </div>
    <a href="{{ route('membre.emprunts.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md hover:shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
        Emprunter un livre
    </a>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
    <!-- Stat 1 -->
    <div class="glass-card rounded-2xl p-6 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-indigo-500/30"></div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-indigo-500/10 text-indigo-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-white">{{ $totalEmprunts }}</div>
            <div class="text-xs font-semibold text-gray-400">Total Emprunts</div>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="glass-card rounded-2xl p-6 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-teal-500/30"></div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-teal-500/10 text-teal-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-white">{{ $empruntsEnCours }}</div>
            <div class="text-xs font-semibold text-gray-400">En cours / Acceptés</div>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="glass-card rounded-2xl p-6 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-amber-500/30"></div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-amber-500/10 text-amber-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-white">{{ $empruntsEnAttente }}</div>
            <div class="text-xs font-semibold text-gray-400">Demandes en attente</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Livres Disponibles -->
    <div class="glass-card rounded-2xl p-6 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
        <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-6">
            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Suggestions de lecture
        </h2>
        
        @if($livresDisponibles->isEmpty())
            <p class="text-gray-400 text-center py-8">Aucun livre disponible actuellement.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($livresDisponibles as $livre)
                    <div class="bg-white/[0.03] border border-white/5 hover:border-indigo-500/25 hover:bg-white/[0.05] rounded-xl p-4 flex gap-4 transition-all duration-200 cursor-pointer group" onclick="window.location.href='{{ route('membre.emprunts.create', ['livre_id' => $livre->id]) }}'">
                        <img src="{{ asset($livre->image ?? 'images/book_cover.png') }}" class="w-16 h-20 object-cover rounded-lg border border-white/10 group-hover:scale-105 transition-transform duration-200 flex-shrink-0" alt="{{ $livre->titre }}">
                        <div class="flex-1 flex flex-col justify-between min-w-0">
                            <div>
                                <div class="font-bold text-white group-hover:text-indigo-400 transition-colors duration-200 line-clamp-1 truncate">{{ $livre->titre }}</div>
                                <div class="text-[10px] text-gray-500 mt-0.5">ISBN: {{ $livre->isbn }}</div>
                                <div class="text-[10px] text-indigo-400 mt-0.5 font-medium">Prêt: {{ $livre->duration_borrow }} jours</div>
                            </div>
                            <div class="flex justify-between items-center mt-2 pt-2 border-t border-white/5">
                                <span class="text-[10px] font-semibold text-teal-400">{{ $livre->nombre_exemplaires }} restants</span>
                                <span class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300 transition-colors duration-200">Emprunter</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-right">
                <a href="{{ route('membre.livres') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors duration-200">Explorer tous les livres &rarr;</a>
            </div>
        @endif
    </div>

    <!-- Mes Emprunts Récents -->
    <div class="glass-card rounded-2xl p-6 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-teal-500 to-teal-600"></div>
        <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-6">
            <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Mes demandes récentes
        </h2>
        
        @if($mesEmprunts->isEmpty())
            <p class="text-gray-400 text-center py-12">Vous n'avez pas encore effectué de demande d'emprunt.</p>
        @else
            <div class="flex flex-col gap-3">
                @foreach($mesEmprunts as $emprunt)
                    <div class="flex justify-between items-center p-4 rounded-xl bg-white/[0.02] border border-white/5">
                        <div>
                            <div class="font-semibold text-white text-sm">{{ $emprunt->livre->titre ?? 'Livre inconnu' }}</div>
                            <div class="text-xs text-gray-400 mt-1">Emprunté le : {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</div>
                        </div>
                        <div>
                            @if($emprunt->statut === 'En attente')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">En attente</span>
                            @elseif($emprunt->statut === 'Accepté' || $emprunt->statut === 'En cours')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Accepté</span>
                            @elseif($emprunt->statut === 'Refusé')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">Refusé</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">{{ $emprunt->statut }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-right">
                <a href="{{ route('membre.mesEmprunts') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors duration-200">Historique complet &rarr;</a>
            </div>
        @endif
    </div>
</div>
@endsection
