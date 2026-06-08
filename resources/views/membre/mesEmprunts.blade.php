@extends('layouts.app')

@section('title', 'Mes Emprunts - BiblioTech')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Mon historique d'emprunts</h1>
        <p class="text-gray-400 text-sm mt-1">Suivez le statut de vos demandes d'emprunt et vos prêts actifs.</p>
    </div>
    <a href="{{ route('membre.emprunts.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
        Nouvel emprunt
    </a>
</div>

<div class="glass-card rounded-2xl p-6 relative overflow-hidden shadow-2xl">
    <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>

    @if($emprunts->isEmpty())
        <div class="text-center py-16 flex flex-col items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 flex items-center justify-center">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <p class="text-gray-300 font-semibold mb-1">Aucun emprunt pour le moment</p>
                <p class="text-gray-500 text-sm mb-5">Explorez notre catalogue et empruntez votre premier livre.</p>
            </div>
            <a href="{{ route('membre.emprunts.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Emprunter mon premier livre
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Livre</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Date Emprunt</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Retour Prévu</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider text-right">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($emprunts as $emprunt)
                        <tr class="hover:bg-white/[0.02] transition-colors duration-150">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($emprunt->livre->image ?? 'images/book_cover.png') }}"
                                        class="w-9 h-12 object-cover rounded-lg border border-white/10 shrink-0 shadow-sm" alt="Couverture">
                                    <div>
                                        <div class="font-semibold text-white text-sm">{{ $emprunt->livre->titre ?? 'Livre inconnu' }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">ISBN: {{ $emprunt->livre->isbn ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-gray-300 text-sm">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                            <td class="py-4 text-gray-300 text-sm">{{ \Carbon\Carbon::parse($emprunt->date_retour_prevue)->format('d/m/Y') }}</td>
                            <td class="py-4 text-right">
                                @if($emprunt->statut === 'En attente')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                        En attente
                                    </span>
                                @elseif($emprunt->statut === 'Accepté' || $emprunt->statut === 'En cours')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        Accepté
                                    </span>
                                @elseif($emprunt->statut === 'Refusé')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                        Refusé
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">{{ $emprunt->statut }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
