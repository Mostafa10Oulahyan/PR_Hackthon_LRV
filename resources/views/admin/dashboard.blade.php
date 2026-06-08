@extends('layouts.app')

@section('title', 'Console Administration - BiblioTech')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Console d'administration</h1>
        <p class="text-gray-400 text-sm mt-1">Bienvenue, Administrateur.</p>
    </div>
    <a href="{{ route('admin.livres.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md hover:shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
        Ajouter un livre
    </a>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat 1 -->
    <div class="glass-card rounded-2xl p-6 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-indigo-500/30"></div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-indigo-500/10 text-indigo-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-white">{{ $totalLivres }}</div>
            <div class="text-xs font-semibold text-gray-400">Livres Référencés</div>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="glass-card rounded-2xl p-6 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-teal-500/30"></div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-teal-500/10 text-teal-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-white">{{ $totalMembres }}</div>
            <div class="text-xs font-semibold text-gray-400">Membres Actifs</div>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="glass-card rounded-2xl p-6 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-amber-500/30"></div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-amber-500/10 text-amber-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-white">{{ $empruntsEnAttente }}</div>
            <div class="text-xs font-semibold text-gray-400">Demandes en attente</div>
        </div>
    </div>
    <!-- Stat 4 -->
    <div class="glass-card rounded-2xl p-6 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-emerald-500/30"></div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-emerald-500/10 text-emerald-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-white">{{ $empruntsEnCours }}</div>
            <div class="text-xs font-semibold text-gray-400">Emprunts en cours</div>
        </div>
    </div>
</div>

<!-- Graph and Ratios Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Monthly Borrowing Stats Graph -->
    <div class="lg:col-span-2 glass-card rounded-2xl p-6 relative overflow-hidden flex flex-col justify-between">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
        
        <div>
            <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Statistiques des emprunts par mois
            </h2>
            <p class="text-xs text-gray-400 mb-6">Volume d'emprunts approuvés et actifs sur l'année en cours.</p>
        </div>

        <div class="h-60 flex items-end gap-2 sm:gap-4 pt-6 pb-2 px-4 border-b border-l border-white/10 relative">
            @php
                $maxBorrow = max(array_values($statsMois)) ?: 1;
            @endphp
            @foreach($statsMois as $mois => $count)
                @php
                    $percent = ($count / $maxBorrow) * 100;
                @endphp
                <div class="flex-1 flex flex-col items-center h-full justify-end group relative">
                    <!-- Tooltip -->
                    <div class="absolute bottom-full mb-2 bg-indigo-600 text-white font-bold text-[10px] px-2.5 py-1 rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-10">
                        {{ $count }} emprunts
                    </div>
                    <!-- Bar -->
                    <div class="w-full bg-gradient-to-t from-indigo-600/20 to-indigo-500 rounded-t-md group-hover:from-indigo-500 group-hover:to-teal-400 transition-all duration-300 relative" style="height: {{ max($percent, 4) }}%">
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-t-md"></div>
                    </div>
                    <!-- Label -->
                    <span class="text-[10px] text-gray-400 font-semibold mt-2">{{ $mois }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Available vs. Borrowed ratio -->
    <div class="glass-card rounded-2xl p-6 relative overflow-hidden flex flex-col justify-between">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-teal-500 to-teal-600"></div>

        <div>
            <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
                Disponibilité du stock
            </h2>
            <p class="text-xs text-gray-400 mb-6">Répartition de tous les exemplaires physiques de livres.</p>
        </div>

        @php
            $totalExemplaires = $livresDisponiblesExemplaires + $livresEmpruntesExemplaires;
            $dispPercent = $totalExemplaires > 0 ? round(($livresDisponiblesExemplaires / $totalExemplaires) * 100) : 100;
            $empPercent = $totalExemplaires > 0 ? round(($livresEmpruntesExemplaires / $totalExemplaires) * 100) : 0;
        @endphp

        <div class="flex-1 flex flex-col justify-center gap-6">
            <div class="space-y-2">
                <div class="flex justify-between items-center text-xs font-semibold">
                    <span class="text-teal-400 flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                        Disponibles : {{ $livresDisponiblesExemplaires }} ex.
                    </span>
                    <span class="text-gray-400">{{ $dispPercent }}%</span>
                </div>
                <div class="flex justify-between items-center text-xs font-semibold">
                    <span class="text-indigo-400 flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                        Empruntés : {{ $livresEmpruntesExemplaires }} ex.
                    </span>
                    <span class="text-gray-400">{{ $empPercent }}%</span>
                </div>
            </div>

            <!-- Horizontal Stacked Progress Bar -->
            <div class="h-6 w-full rounded-xl overflow-hidden bg-white/5 flex border border-white/10 shadow-inner">
                <div class="bg-gradient-to-r from-teal-500 to-teal-400 h-full transition-all duration-500 shadow-[0_0_10px_rgba(20,184,166,0.2)]" style="width: {{ $dispPercent }}%"></div>
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-full transition-all duration-500 shadow-[0_0_10px_rgba(99,102,241,0.2)]" style="width: {{ $empPercent }}%"></div>
            </div>

            <div class="p-4 rounded-xl bg-white/[0.02] border border-white/5 text-center text-xs text-gray-400">
                Total physique de <strong class="text-white">{{ $totalExemplaires }}</strong> exemplaires gérés dans BiblioTech Cloud.
            </div>
        </div>
    </div>
</div>

<!-- Leaderboard & Popular Books Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Top 10 Popular Books -->
    <div class="lg:col-span-2 glass-card rounded-2xl p-6 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-amber-500 to-amber-600"></div>
        <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.399 1.25 1.18 1.88l-3.97 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.89a1 1 0 00-1.175 0l-3.97 2.89c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.97-2.89c-.22-.63.218-1.88 1.18-1.88h4.908a1 1 0 00.95-.69l1.519-4.674z"></path>
            </svg>
            Top 10 des livres les plus populaires
        </h2>
        <p class="text-xs text-gray-400 mb-6">Livres les plus demandés et aimés par les lecteurs.</p>

        @if($topLivres->isEmpty())
            <p class="text-gray-400 text-center py-8">Aucune statistique disponible pour le moment.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[420px] overflow-y-auto pr-1">
                @foreach($topLivres as $index => $livre)
                    <div class="flex items-center justify-between gap-3.5 p-3 rounded-xl bg-white/[0.02] border border-white/5 hover:border-amber-500/20 transition-all duration-200 group/item">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <!-- Rank circle -->
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center font-outfit font-black text-xs {{ $index === 0 ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/25' : ($index === 1 ? 'bg-slate-300 text-black' : ($index === 2 ? 'bg-amber-700 text-white' : 'bg-white/5 text-gray-400')) }} flex-shrink-0">
                                #{{ $index + 1 }}
                            </div>
                            <img src="{{ asset($livre->image ?? 'images/book_cover.png') }}" class="w-10 h-14 object-cover rounded border border-white/10 flex-shrink-0" alt="Couverture">
                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-white text-xs truncate">{{ $livre->titre }}</h4>
                                <div class="text-[10px] text-gray-500 mt-0.5">ISBN : {{ $livre->isbn }}</div>
                                <span class="inline-flex items-center mt-1 px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    {{ $livre->emprunts_count }} emprunts
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('admin.livres.edit', $livre->id) }}" class="p-2 rounded-lg bg-indigo-500/10 hover:bg-indigo-600 hover:text-white text-indigo-400 border border-indigo-500/20 transition-all duration-150 cursor-pointer flex-shrink-0 opacity-0 group-hover/item:opacity-100" title="Modifier le livre">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Active Readers Leaderboard Table -->
    <div class="glass-card rounded-2xl p-6 relative overflow-hidden flex flex-col">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-fuchsia-500 to-indigo-500"></div>
        <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-2">
            <svg class="w-5 h-5 text-fuchsia-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path>
            </svg>
            Classement complet des Lecteurs
        </h2>
        <p class="text-xs text-gray-400 mb-6">Membres ordonnés par points et statistiques d'emprunt.</p>

        @if($leaderboard->isEmpty())
            <p class="text-gray-400 text-center py-12 flex-1 flex items-center justify-center">Aucun membre actif.</p>
        @else
            <div class="overflow-x-auto flex-1 max-h-[420px] overflow-y-auto pr-1">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-white/10 text-gray-400 font-semibold uppercase tracking-wider">
                            <th class="pb-3 text-center">Rang</th>
                            <th class="pb-3 pl-2">Lecteur</th>
                            <th class="pb-3 text-center">Badge</th>
                            <th class="pb-3 text-center">Prêts (Actifs/T.)</th>
                            <th class="pb-3 text-right">Points</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($leaderboard as $index => $u)
                            @php
                                $totalLoans = $u->emprunts->count();
                                $activeLoans = $u->emprunts->whereIn('statut', ['Accepté', 'En cours'])->count();
                            @endphp
                            <tr class="hover:bg-white/[0.02] transition-colors duration-150">
                                <td class="py-3.5 text-center font-outfit font-bold text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3.5 pl-2">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ asset($u->image_profile ?? 'images/user_avatar.png') }}" class="w-7 h-7 rounded-full border border-white/10 object-cover flex-shrink-0" alt="Avatar">
                                        <div class="font-bold text-white truncate max-w-[100px]">{{ $u->name }}</div>
                                    </div>
                                </td>
                                <td class="py-3.5 text-center">
                                    <span class="inline-flex items-center gap-0.5 text-[8px] font-bold tracking-wider rounded uppercase px-1.5 py-0.5 bg-gradient-to-r {{ $u->badge['color'] }}">
                                        {{ $u->badge['icon'] }} {{ $u->badge['name'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-center font-medium text-gray-300">
                                    <span class="text-teal-400 font-bold">{{ $activeLoans }}</span>
                                    <span class="text-gray-600">/</span>
                                    <span class="text-gray-400">{{ $totalLoans }}</span>
                                </td>
                                <td class="py-3.5 text-right font-black text-fuchsia-400">
                                    {{ $u->points }} pts
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Raw lists Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Emprunts -->
    <div class="lg:col-span-2 glass-card rounded-2xl p-6 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-indigo-600"></div>
        <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-6">
            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Demandes d'emprunt récentes
        </h2>
        
        @if($recentEmprunts->isEmpty())
            <p class="text-gray-400 text-center py-8">Aucune demande enregistrée pour le moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="pb-3 text-gray-400 font-semibold uppercase text-xs tracking-wider">Membre</th>
                            <th class="pb-3 text-gray-400 font-semibold uppercase text-xs tracking-wider">Livre</th>
                            <th class="pb-3 text-gray-400 font-semibold uppercase text-xs tracking-wider">Date Demande</th>
                            <th class="pb-3 text-gray-400 font-semibold uppercase text-xs tracking-wider">Statut</th>
                            <th class="pb-3 text-gray-400 font-semibold uppercase text-xs tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($recentEmprunts as $emprunt)
                            <tr>
                                <td class="py-4">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ asset($emprunt->user->image_profile ?? 'images/user_avatar.png') }}" class="w-8 h-8 rounded-full border border-white/10 object-cover flex-shrink-0" alt="Avatar">
                                        <div>
                                            <div class="font-semibold text-white text-xs">{{ $emprunt->user->name ?? 'Membre inconnu' }}</div>
                                            <div class="text-[10px] text-gray-400">{{ $emprunt->user->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 font-medium text-white text-xs max-w-[140px] truncate">{{ $emprunt->livre->titre ?? 'Livre inconnu' }}</td>
                                <td class="py-4 text-gray-300 text-xs">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                <td class="py-4">
                                    @if($emprunt->statut === 'En attente')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">En attente</span>
                                    @elseif($emprunt->statut === 'Accepté' || $emprunt->statut === 'En cours')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Accepté</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-500/10 text-red-400 border border-red-500/20">{{ $emprunt->statut }}</span>
                                    @endif
                                </td>
                                <td class="py-4 text-right">
                                    @if($emprunt->statut === 'En attente')
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('admin.emprunts.accept', $emprunt->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 rounded bg-emerald-500/10 hover:bg-emerald-500 text-emerald-400 hover:text-white border border-emerald-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer">Accepter</button>
                                            </form>
                                            <form action="{{ route('admin.emprunts.refuse', $emprunt->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 rounded bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white border border-red-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer">Refuser</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Traité</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6 text-right">
                <a href="{{ route('admin.emprunts') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors duration-200">Voir toutes les demandes &rarr;</a>
            </div>
        @endif
    </div>

    <!-- Recent Livres -->
    <div class="glass-card rounded-2xl p-6 relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-teal-500 to-teal-600"></div>
        <h2 class="text-lg font-outfit font-bold flex items-center gap-2 mb-6">
            <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Livres récents
        </h2>
        
        @if($livres->isEmpty())
            <p class="text-gray-400 text-center py-8">Aucun livre enregistré.</p>
        @else
            <div class="flex flex-col divide-y divide-white/5">
                @foreach($livres as $livre)
                    <div class="py-3.5 flex items-center justify-between gap-4 first:pt-0 last:pb-0 group/item">
                        <div class="flex items-center gap-4 min-w-0 flex-1">
                            <img src="{{ asset($livre->image ?? 'images/book_cover.png') }}" class="w-10 h-12 object-cover rounded border border-white/10 flex-shrink-0" alt="Couverture">
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-white truncate text-sm">{{ $livre->titre }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">ISBN: {{ $livre->isbn }} | Prêt: {{ $livre->duration_borrow }} j.</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 flex-shrink-0">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-md {{ $livre->nombre_exemplaires > 0 ? 'bg-teal-500/10 text-teal-400 border border-teal-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                                {{ $livre->nombre_exemplaires }} ex.
                            </span>
                            <a href="{{ route('admin.livres.edit', $livre->id) }}" class="p-1.5 rounded-md bg-indigo-500/10 hover:bg-indigo-600 hover:text-white text-indigo-400 border border-indigo-500/20 transition-all duration-150 cursor-pointer opacity-0 group-hover/item:opacity-100" title="Modifier le livre">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
