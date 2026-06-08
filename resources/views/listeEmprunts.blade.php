@extends('layouts.app')

@section('title', 'Liste des Emprunts - BiblioTech Cloud')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Tableau de Bord des Emprunts</h1>
        <p class="text-gray-400 text-sm mt-1">Gérer les emprunts et les retours de livres</p>
    </div>
    <a href="{{ route('emprunts.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nouvel Emprunt
    </a>
</div>

<div class="glass-card rounded-2xl p-6 relative overflow-hidden shadow-2xl">
    <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>
    
    @if($emprunts->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">ID</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Livre</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Membre</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Date d'Emprunt</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Date de Retour Prévue</th>
                        <th class="pb-4 text-gray-400 font-semibold uppercase text-xs tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($emprunts as $emprunt)
                        <tr class="hover:bg-white/[0.02] transition-colors duration-150">
                            <td class="py-4 font-bold text-indigo-400">#{{ $emprunt->id }}</td>
                            <td class="py-4 font-semibold text-white">{{ $emprunt->livre->titre ?? 'Livre inconnu' }}</td>
                            <td class="py-4 text-gray-200">{{ $emprunt->user->name ?? 'Membre inconnu' }}</td>
                            <td class="py-4 text-gray-300">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                            <td class="py-4 text-gray-300">{{ \Carbon\Carbon::parse($emprunt->date_retour_prevue)->format('d/m/Y') }}</td>
                            <td class="py-4">
                                @if($emprunt->statut === 'En cours' || $emprunt->statut === 'En attente')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">En cours</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Retourné</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-16">
            <div class="text-4xl text-indigo-400/40 mb-4">📂</div>
            <h3 class="text-lg font-bold text-white mb-1">Aucun emprunt trouvé</h3>
            <p class="text-gray-400 text-sm">Commencez par ajouter un nouvel emprunt de livre dans le système.</p>
        </div>
    @endif
</div>
@endsection
