@extends('layouts.app')

@section('title', 'Mon Espace - BiblioTech')

@section('content')
@php
    $points = $user->points ?? 0;
    $badge = $user->badge;
    $nextBadgeName = '';
    $pointsNeeded = 0;
    $progressPercent = 0;

    if ($points < 50) {
        $nextBadgeName = 'Lecteur régulier';
        $pointsNeeded = 50 - $points;
        $progressPercent = round(($points / 50) * 100);
    } elseif ($points < 150) {
        $nextBadgeName = 'Lecteur expert';
        $pointsNeeded = 150 - $points;
        $progressPercent = round((($points - 50) / 100) * 100);
    } elseif ($points < 300) {
        $nextBadgeName = 'Maître des Livres';
        $pointsNeeded = 300 - $points;
        $progressPercent = round((($points - 150) / 150) * 100);
    } else {
        $nextBadgeName = 'Niveau Maximum Atteint';
        $pointsNeeded = 0;
        $progressPercent = 100;
    }
@endphp

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

<!-- Stats / Gamification Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
    <!-- Traditional Stats Cards -->
    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-6">
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
                <div class="text-xs font-semibold text-gray-400">Prêts actifs</div>
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
                <div class="text-xs font-semibold text-gray-400">En attente</div>
            </div>
        </div>
    </div>

    <!-- Gamification Badge card -->
    <div class="glass-card rounded-2xl p-6 relative overflow-hidden flex flex-col justify-between shadow-lg">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r {{ $badge['color'] }}"></div>
        
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <span class="text-2xl">{{ $badge['icon'] }}</span>
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Mon Niveau</h3>
                    <div class="font-outfit font-black text-sm text-white tracking-wide uppercase">{{ $badge['name'] }}</div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-black text-indigo-400">{{ $points }}</div>
                <div class="text-[9px] text-gray-400 uppercase font-semibold">Points Fidélité</div>
            </div>
        </div>

        <div class="space-y-2">
            <div class="flex justify-between text-[10px] text-gray-450 font-bold">
                @if($pointsNeeded > 0)
                    <span class="text-gray-400">Prochain niveau : <strong class="text-indigo-400 font-extrabold">{{ $nextBadgeName }}</strong></span>
                    <span class="text-indigo-300">Encore {{ $pointsNeeded }} pts</span>
                @else
                    <span class="text-fuchsia-400 font-extrabold">👑 Niveau Maximum</span>
                    <span class="text-gray-400">Bravo !</span>
                @endif
            </div>
            <!-- Progress Bar -->
            <div class="h-2 w-full rounded-full bg-white/5 border border-white/5 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-indigo-500 to-teal-400 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Interactive Area -->
    <div class="lg:col-span-2 flex flex-col">
        <!-- Tabs Navigation -->
        <div class="flex border-b border-white/10 mb-6 flex-wrap sm:flex-nowrap">
            <button onclick="switchTab('suggestions')" id="tab-btn-suggestions" class="px-5 py-3 text-xs sm:text-sm font-semibold border-b-2 border-indigo-500 text-white transition-all cursor-pointer">
                Suggestions de lecture
            </button>
            <button onclick="switchTab('favoris')" id="tab-btn-favoris" class="px-5 py-3 text-xs sm:text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-white transition-all cursor-pointer">
                Mes Favoris (<span id="fav-count">{{ $favoris->count() }}</span>)
            </button>
            <button onclick="switchTab('historique')" id="tab-btn-historique" class="px-5 py-3 text-xs sm:text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-white transition-all cursor-pointer">
                Historique complet
            </button>
        </div>

        <!-- Tab 1: Suggestions -->
        <div id="tab-content-suggestions" class="tab-pane">
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
                            @php
                                $isFav = in_array($livre->id, $userFavorisIds);
                            @endphp
                            <div class="bg-white/[0.03] border border-white/5 hover:border-indigo-500/25 hover:bg-white/[0.05] rounded-xl p-4 flex gap-4 transition-all duration-200 cursor-pointer group relative" onclick="window.location.href='{{ route('membre.emprunts.create', ['livre_id' => $livre->id]) }}'">
                                <!-- Favorite Heart Icon -->
                                <button onclick="event.stopPropagation(); toggleFavoriteDashboard({{ $livre->id }}, this)" class="absolute top-3 right-3 p-1.5 rounded-lg bg-black/40 hover:bg-black/60 text-gray-400 hover:text-red-500 transition duration-150 z-10">
                                    <svg class="w-4 h-4 {{ $isFav ? 'fill-red-500 text-red-500' : 'text-gray-400' }}" fill="{{ $isFav ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>

                                <img src="{{ asset($livre->image ?? 'images/book_cover.png') }}" class="w-16 h-20 object-cover rounded-lg border border-white/10 group-hover:scale-105 transition-transform duration-200 flex-shrink-0" alt="{{ $livre->titre }}">
                                <div class="flex-1 flex flex-col justify-between min-w-0">
                                    <div>
                                        <div class="font-bold text-white group-hover:text-indigo-400 transition-colors duration-200 line-clamp-1 truncate text-xs">{{ $livre->titre }}</div>
                                        <div class="text-[9px] text-gray-500 mt-0.5">ISBN: {{ $livre->isbn }}</div>
                                        <div class="text-[9px] text-indigo-400 mt-0.5 font-medium">Prêt: {{ $livre->duration_borrow }} jours</div>
                                    </div>
                                    <div class="flex justify-between items-center mt-2 pt-2 border-t border-white/5">
                                        <span class="text-[9px] font-semibold text-teal-400">{{ $livre->nombre_exemplaires }} restants</span>
                                        <span class="text-[9px] font-bold text-indigo-400 hover:text-indigo-300 transition-colors duration-200">Emprunter</span>
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
        </div>

        <!-- Tab 2: Favorites -->
        <div id="tab-content-favoris" class="tab-pane hidden">
            <div class="glass-card rounded-2xl p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-red-500 to-red-650"></div>
                <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                    </svg>
                    Mes Livres Favoris
                </h2>

                <div id="favorites-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($favoris->isEmpty())
                        <div id="no-favorites-msg" class="col-span-full text-center py-12">
                            <p class="text-gray-400 text-sm">Vous n'avez pas encore de livres en favoris.</p>
                            <p class="text-gray-500 text-xs mt-1">Parcourez le catalogue et cliquez sur le cœur pour en ajouter !</p>
                        </div>
                    @else
                        @foreach($favoris as $livre)
                            <div class="bg-white/[0.03] border border-white/5 hover:border-indigo-500/25 hover:bg-white/[0.05] rounded-xl p-4 flex gap-4 transition-all duration-200 cursor-pointer group relative" onclick="window.location.href='{{ route('membre.emprunts.create', ['livre_id' => $livre->id]) }}'" id="fav-card-{{ $livre->id }}">
                                <!-- Favorite Heart Icon -->
                                <button onclick="event.stopPropagation(); removeFavoriteDashboard({{ $livre->id }}, this)" class="absolute top-3 right-3 p-1.5 rounded-lg bg-black/40 hover:bg-black/60 text-red-500 transition duration-150 z-10">
                                    <svg class="w-4 h-4 fill-red-500" fill="currentColor" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>

                                <img src="{{ asset($livre->image ?? 'images/book_cover.png') }}" class="w-16 h-20 object-cover rounded-lg border border-white/10 group-hover:scale-105 transition-transform duration-200 flex-shrink-0" alt="{{ $livre->titre }}">
                                <div class="flex-1 flex flex-col justify-between min-w-0">
                                    <div>
                                        <div class="font-bold text-white group-hover:text-indigo-400 transition-colors duration-200 line-clamp-1 truncate text-xs">{{ $livre->titre }}</div>
                                        <div class="text-[9px] text-gray-500 mt-0.5">ISBN: {{ $livre->isbn }}</div>
                                        <div class="text-[9px] text-indigo-400 mt-0.5 font-medium">Prêt: {{ $livre->duration_borrow }} jours</div>
                                    </div>
                                    <div class="flex justify-between items-center mt-2 pt-2 border-t border-white/5">
                                        <span class="text-[9px] font-semibold {{ $livre->nombre_exemplaires > 0 ? 'text-teal-400' : 'text-red-400' }}">
                                            {{ $livre->nombre_exemplaires > 0 ? $livre->nombre_exemplaires . ' restants' : 'Indisponible' }}
                                        </span>
                                        <span class="text-[9px] font-bold text-indigo-400 hover:text-indigo-300 transition-colors duration-200">Emprunter</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab 3: Complete Borrow History -->
        <div id="tab-content-historique" class="tab-pane hidden">
            <div class="glass-card rounded-2xl p-6 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-teal-500 to-indigo-600"></div>
                <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-teal-450" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Historique complet des emprunts
                </h2>

                @if($historiqueEmprunts->isEmpty())
                    <p class="text-gray-400 text-center py-12">Vous n'avez pas encore effectué de demande d'emprunt.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-white/10 text-gray-400 font-semibold uppercase tracking-wider">
                                    <th class="pb-3">Livre</th>
                                    <th class="pb-3">Date Emprunt</th>
                                    <th class="pb-3">Retour Prévu</th>
                                    <th class="pb-3 text-right">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($historiqueEmprunts as $emprunt)
                                    <tr>
                                        <td class="py-3.5">
                                            <div class="font-bold text-white text-xs">{{ $emprunt->livre->titre ?? 'Livre inconnu' }}</div>
                                            <div class="text-[10px] text-gray-500">ISBN : {{ $emprunt->livre->isbn ?? '' }}</div>
                                        </td>
                                        <td class="py-3.5 text-gray-300 font-medium">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                        <td class="py-3.5 text-gray-300 font-medium">{{ \Carbon\Carbon::parse($emprunt->date_retour_prevue)->format('d/m/Y') }}</td>
                                        <td class="py-3.5 text-right">
                                            @if($emprunt->statut === 'En attente')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">En attente</span>
                                            @elseif($emprunt->statut === 'Accepté' || $emprunt->statut === 'En cours')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Accepté</span>
                                            @elseif($emprunt->statut === 'Refusé')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-red-500/10 text-red-400 border border-red-500/20">Refusé</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-red-500/10 text-red-400 border border-red-500/20">{{ $emprunt->statut }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Active Readers Leaderboard Sidebar -->
    <div class="glass-card rounded-2xl p-6 relative overflow-hidden flex flex-col h-fit">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-fuchsia-500 to-indigo-500"></div>
        <h2 class="text-base font-outfit font-bold flex items-center gap-2 mb-2 text-white">
            <svg class="w-4 h-4 text-fuchsia-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path>
            </svg>
            Classement des Lecteurs
        </h2>
        <p class="text-[11px] text-gray-400 mb-6">Les lecteurs les plus actifs de la communauté.</p>

        @if($leaderboard->isEmpty())
            <p class="text-gray-400 text-center py-6 text-xs">Aucun lecteur répertorié.</p>
        @else
            <div class="flex flex-col gap-4">
                @foreach($leaderboard as $index => $u)
                    <div class="flex items-center justify-between p-3 rounded-xl {{ $u->id === $user->id ? 'bg-indigo-500/10 border border-indigo-500/30 shadow-[0_0_10px_rgba(99,102,241,0.08)]' : 'bg-white/[0.01] border border-white/5' }} hover:bg-white/[0.03] transition-colors duration-150">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="font-outfit font-black text-xs {{ $u->id === $user->id ? 'text-indigo-400' : 'text-gray-500' }} w-4">{{ $index + 1 }}.</span>
                            <img src="{{ asset($u->image_profile ?? 'images/user_avatar.png') }}" class="w-7 h-7 rounded-full border border-white/10 object-cover flex-shrink-0" alt="Avatar">
                            <div class="min-w-0">
                                <h4 class="font-bold text-white text-xs truncate flex items-center gap-1">
                                    {{ $u->name }}
                                    @if($u->id === $user->id)
                                        <span class="text-[9px] text-indigo-450 bg-indigo-500/20 px-1 py-0.2 rounded font-semibold">Moi</span>
                                    @endif
                                </h4>
                                <span class="inline-flex items-center gap-0.5 text-[8px] font-bold tracking-wider rounded uppercase px-1 py-0.2 bg-gradient-to-r {{ $u->badge['color'] }} mt-0.5">
                                    {{ $u->badge['icon'] }} {{ $u->badge['name'] }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-black {{ $u->id === $user->id ? 'text-indigo-450' : 'text-fuchsia-400' }}">{{ $u->points }} pts</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    // Tab switching logic
    function switchTab(tabName) {
        // Hide all content panes
        document.querySelectorAll('.tab-pane').forEach(el => {
            el.classList.add('hidden');
        });
        
        // Remove active class from all buttons
        const buttons = [
            { id: 'tab-btn-suggestions', activeBorder: 'border-indigo-500', activeText: 'text-white', inactiveText: 'text-gray-400' },
            { id: 'tab-btn-favoris', activeBorder: 'border-red-500', activeText: 'text-white', inactiveText: 'text-gray-400' },
            { id: 'tab-btn-historique', activeBorder: 'border-teal-500', activeText: 'text-white', inactiveText: 'text-gray-400' }
        ];

        buttons.forEach(btn => {
            const el = document.getElementById(btn.id);
            if (el) {
                el.classList.remove('border-indigo-500', 'border-red-500', 'border-teal-500', 'text-white');
                el.classList.add('border-transparent', 'text-gray-400');
            }
        });

        // Show target content pane
        const activePane = document.getElementById('tab-content-' + tabName);
        if (activePane) {
            activePane.classList.remove('hidden');
        }

        // Highlight active button
        const activeBtn = document.getElementById('tab-btn-' + tabName);
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-gray-400');
            let borderClass = 'border-indigo-500';
            if (tabName === 'favoris') borderClass = 'border-red-500';
            if (tabName === 'historique') borderClass = 'border-teal-500';
            activeBtn.classList.add(borderClass, 'text-white');
        }
    }

    // Toggle favorites helper for Dashboard Suggestions view
    async function toggleFavoriteDashboard(bookId, btnElement) {
        try {
            const res = await fetch(`/membre/favoris/toggle/${bookId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            const data = await res.json();
            if (data.status === 'success') {
                const svg = btnElement.querySelector('svg');
                if (data.attached) {
                    svg.classList.add('fill-red-500', 'text-red-500');
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    svg.classList.remove('fill-red-500', 'text-red-500');
                    svg.classList.add('text-gray-400');
                    svg.setAttribute('fill', 'none');
                }
                
                // Reload Favorites count or visual lists dynamically
                window.location.reload();
            }
        } catch (e) {
            console.error("Favorite toggle failed:", e);
        }
    }

    // Remove favorite directly from Favorites view
    async function removeFavoriteDashboard(bookId, btnElement) {
        try {
            const res = await fetch(`/membre/favoris/toggle/${bookId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            const data = await res.json();
            if (data.status === 'success' && !data.attached) {
                const card = document.getElementById('fav-card-' + bookId);
                if (card) {
                    card.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        card.remove();
                        const grid = document.getElementById('favorites-grid');
                        const countEl = document.getElementById('fav-count');
                        if (countEl) {
                            const newCount = Math.max(0, parseInt(countEl.innerText) - 1);
                            countEl.innerText = newCount;
                            
                            if (newCount === 0 && grid) {
                                grid.innerHTML = `
                                    <div id="no-favorites-msg" class="col-span-full text-center py-12">
                                        <p class="text-gray-400 text-sm">Vous n'avez pas encore de livres en favoris.</p>
                                        <p class="text-gray-500 text-xs mt-1">Parcourez le catalogue et cliquez sur le cœur pour en ajouter !</p>
                                    </div>
                                `;
                            }
                        }
                    }, 200);
                }
            }
        } catch (e) {
            console.error("Favorite removal failed:", e);
        }
    }
</script>
@endsection
