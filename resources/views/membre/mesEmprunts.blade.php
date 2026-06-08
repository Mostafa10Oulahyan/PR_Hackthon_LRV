@extends('layouts.app')

@section('title', 'Mes Emprunts - BiblioTech')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Mon historique d'emprunts</h1>
    <p class="text-gray-400 text-sm mt-1">Suivez le statut de vos demandes d'emprunt et vos prêts actifs.</p>
</div>

<div class="glass-card rounded-2xl p-6 relative overflow-hidden shadow-2xl">
    <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>

    @if($emprunts->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-400 text-lg mb-6">Vous n'avez effectué aucun emprunt pour le moment.</p>
            <a href="{{ route('membre.emprunts.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">Emprunter mon premier livre</a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Livre</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Date Emprunt</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Retour Prévu</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($emprunts as $emprunt)
                        <tr>
                            <td class="py-4">
                                <div class="font-semibold text-white">{{ $emprunt->livre->titre ?? 'Livre inconnu' }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">ISBN: {{ $emprunt->livre->isbn ?? '' }}</div>
                            </td>
                            <td class="py-4 text-gray-300">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                            <td class="py-4 text-gray-300">{{ \Carbon\Carbon::parse($emprunt->date_retour_prevue)->format('d/m/Y') }}</td>
                            <td class="py-4">
                                @if($emprunt->statut === 'En attente')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">En attente</span>
                                @elseif($emprunt->statut === 'Accepté' || $emprunt->statut === 'En cours')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Accepté</span>
                                @elseif($emprunt->statut === 'Refusé')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">Refusé</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">{{ $emprunt->statut }}</span>
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
