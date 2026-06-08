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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
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
                                <td class="py-4 font-medium text-white">{{ $emprunt->livre->titre ?? 'Livre inconnu' }}</td>
                                <td class="py-4 text-gray-300">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                <td class="py-4">
                                    @if($emprunt->statut === 'En attente')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">En attente</span>
                                    @elseif($emprunt->statut === 'Accepté' || $emprunt->statut === 'En cours')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Accepté</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">{{ $emprunt->statut }}</span>
                                    @endif
                                </td>
                                <td class="py-4 text-right">
                                    @if($emprunt->statut === 'En attente')
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('admin.emprunts.accept', $emprunt->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 rounded bg-emerald-500/10 hover:bg-emerald-500 text-emerald-400 hover:text-white border border-emerald-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer">Accepter</button>
                                            </form>
                                            <form action="{{ route('admin.emprunts.refuse', $emprunt->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 rounded bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white border border-red-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer">Refuser</button>
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
                    <div class="py-3.5 flex items-center gap-4 first:pt-0 last:pb-0">
                        <img src="{{ asset($livre->image ?? 'images/book_cover.png') }}" class="w-10 h-12 object-cover rounded border border-white/10 flex-shrink-0" alt="Couverture">
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-white truncate text-sm">{{ $livre->titre }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">ISBN: {{ $livre->isbn }} | Prêt: {{ $livre->duration_borrow }} j.</div>
                        </div>
                        <span class="flex-shrink-0 text-xs font-semibold px-2 py-0.5 rounded-md {{ $livre->nombre_exemplaires > 0 ? 'bg-teal-500/10 text-teal-400 border border-teal-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                            {{ $livre->nombre_exemplaires }} ex.
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
