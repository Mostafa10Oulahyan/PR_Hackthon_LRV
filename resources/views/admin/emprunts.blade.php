@extends('layouts.app')

@section('title', 'Gestion des Emprunts - BiblioTech')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Gestion de tous les emprunts</h1>
    <p class="text-gray-400 text-sm mt-1">Consultez, validez ou refusez les demandes d'emprunt des membres.</p>
</div>

<div class="glass-card rounded-2xl p-6 relative overflow-hidden shadow-2xl">
    <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>

    @if($emprunts->isEmpty())
        <p class="text-gray-400 text-center py-12">Aucune demande d'emprunt enregistrée sur la plateforme.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Membre</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Livre</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Date Emprunt</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Retour Prévu</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Statut</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($emprunts as $emprunt)
                        <tr>
                            <td class="py-4">
                                <div class="font-semibold text-white">{{ $emprunt->user->name ?? 'Membre inconnu' }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $emprunt->user->email ?? '' }}</div>
                            </td>
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
                            <td class="py-4 text-right">
                                <div class="flex items-center justify-end gap-2.5">
                                    @if($emprunt->statut === 'En attente')
                                        <form action="{{ route('admin.emprunts.accept', $emprunt->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded bg-emerald-500/10 hover:bg-emerald-500 text-emerald-400 hover:text-white border border-emerald-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer">Accepter</button>
                                        </form>
                                        <form action="{{ route('admin.emprunts.refuse', $emprunt->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white border border-red-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer">Refuser</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.emprunts.reset', $emprunt->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white border border-amber-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer" title="Réinitialiser à En attente">
                                                Modifier
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.emprunts.delete', $emprunt->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet emprunt ?')">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1.5 rounded bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white border border-red-500/20 hover:border-red-600 transition-all duration-150 text-xs font-semibold cursor-pointer" title="Supprimer l'enregistrement">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
