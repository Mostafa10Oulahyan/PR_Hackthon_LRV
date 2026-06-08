@extends('layouts.app')

@section('title', 'Gestion des Emprunts - BiblioTech')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Gestion de tous les emprunts</h1>
        <p class="text-gray-400 text-sm mt-1">Consultez, validez ou refusez les demandes d'emprunt des membres.</p>
    </div>
    <div class="flex items-center gap-2 text-sm text-gray-400">
        <span class="px-2 py-1 rounded-md bg-white/5 border border-white/5 font-semibold text-white">{{ $emprunts->count() }}</span>
        demandes au total
    </div>
</div>

<!-- Status Filter Tabs -->
<div class="flex items-center gap-1 mb-6 bg-white/[0.02] border border-white/5 p-1 rounded-xl w-fit flex-wrap">
    @foreach(['Tous' => null, 'En attente' => 'amber', 'Accepté' => 'emerald', 'Refusé' => 'red'] as $label => $color)
        @php
            $count = $label === 'Tous'
                ? $emprunts->count()
                : $emprunts->where('statut', $label)->count();
        @endphp
        <button onclick="filterEmprunts('{{ $label }}')" data-filter="{{ $label }}"
            class="filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200 cursor-pointer flex items-center gap-1.5 {{ $label === 'Tous' ? 'bg-white/10 text-white shadow-sm' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
            @if($color)
                <span class="w-2 h-2 rounded-full bg-{{ $color }}-400 opacity-80"></span>
            @endif
            {{ $label }}
            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $label === 'Tous' ? 'bg-white/10 text-gray-300' : 'bg-white/5 text-gray-500' }}">{{ $count }}</span>
        </button>
    @endforeach
</div>

<div class="glass-card rounded-2xl p-6 relative overflow-hidden shadow-2xl">
    <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>

    @if($emprunts->isEmpty())
        <p class="text-gray-400 text-center py-12">Aucune demande d'emprunt enregistrée sur la plateforme.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse" id="emprunts-table">
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
                        @php
                            $statut = $emprunt->statut;
                            $statutNorm = ($statut === 'Accepté' || $statut === 'En cours') ? 'Accepté' : $statut;
                        @endphp
                        <tr class="emprunt-row hover:bg-white/[0.02] transition-colors duration-150" data-statut="{{ $statutNorm }}">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($emprunt->user->image_profile ?? 'images/user_avatar.png') }}"
                                        class="w-9 h-9 rounded-full border border-white/10 object-cover shrink-0 shadow-sm" alt="Avatar">
                                    <div>
                                        <div class="font-semibold text-white text-sm">{{ $emprunt->user->name ?? 'Membre inconnu' }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $emprunt->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($emprunt->livre->image ?? 'images/book_cover.png') }}"
                                        class="w-8 h-11 object-cover rounded border border-white/10 shrink-0" alt="Couverture">
                                    <div>
                                        <div class="font-semibold text-white text-sm max-w-[160px] truncate">{{ $emprunt->livre->titre ?? 'Livre inconnu' }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">ISBN: {{ $emprunt->livre->isbn ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-gray-300 text-sm">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                            <td class="py-4 text-gray-300 text-sm">{{ \Carbon\Carbon::parse($emprunt->date_retour_prevue)->format('d/m/Y') }}</td>
                            <td class="py-4">
                                @if($statut === 'En attente')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                        En attente
                                    </span>
                                @elseif($statut === 'Accepté' || $statut === 'En cours')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        Accepté
                                    </span>
                                @elseif($statut === 'Refusé')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                        Refusé
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">{{ $statut }}</span>
                                @endif
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($statut === 'En attente')
                                        <form action="{{ route('admin.emprunts.accept', $emprunt->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500 text-emerald-400 hover:text-white border border-emerald-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                                Accepter
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.emprunts.refuse', $emprunt->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white border border-red-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Refuser
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.emprunts.reset', $emprunt->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-white border border-amber-500/20 transition-all duration-150 text-xs font-semibold cursor-pointer" title="Réinitialiser à En attente">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                Modifier
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.emprunts.delete', $emprunt->id) }}" method="POST" class="inline delete-emprunt-form">
                                        @csrf
                                        <button type="button" onclick="confirmDelete(this.closest('form'))"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-500/5 hover:bg-red-600 text-red-500 hover:text-white border border-red-500/15 hover:border-red-600 transition-all duration-150 text-xs font-semibold cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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

        <!-- No results message (hidden by default) -->
        <div id="no-filter-results" class="hidden text-center py-10 text-gray-400 text-sm">
            Aucun emprunt ne correspond à ce filtre.
        </div>
    @endif
</div>

<!-- Inline delete confirm overlay -->
<div id="delete-confirm-overlay" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="glass-card rounded-2xl p-6 max-w-sm w-full relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-red-500 to-red-600"></div>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="font-outfit font-bold text-white">Confirmer la suppression</h3>
                <p class="text-gray-400 text-xs mt-0.5">Cette action est irréversible.</p>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="cancelDelete()" class="flex-1 px-4 py-2.5 rounded-lg text-sm font-semibold text-gray-300 bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-200 cursor-pointer">Annuler</button>
            <button id="confirm-delete-btn" class="flex-1 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition-all duration-200 cursor-pointer">Supprimer</button>
        </div>
    </div>
</div>

<script>
    let formToDelete = null;

    function filterEmprunts(statut) {
        const rows = document.querySelectorAll('.emprunt-row');
        const btns = document.querySelectorAll('.filter-btn');
        let visible = 0;

        btns.forEach(btn => {
            const isActive = btn.getAttribute('data-filter') === statut;
            btn.classList.toggle('bg-white/10', isActive);
            btn.classList.toggle('text-white', isActive);
            btn.classList.toggle('shadow-sm', isActive);
            btn.classList.toggle('text-gray-400', !isActive);
        });

        rows.forEach(row => {
            const show = statut === 'Tous' || row.getAttribute('data-statut') === statut;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        document.getElementById('no-filter-results').classList.toggle('hidden', visible > 0);
    }

    function confirmDelete(form) {
        formToDelete = form;
        document.getElementById('delete-confirm-overlay').classList.remove('hidden');
    }

    function cancelDelete() {
        formToDelete = null;
        document.getElementById('delete-confirm-overlay').classList.add('hidden');
    }

    document.getElementById('confirm-delete-btn')?.addEventListener('click', () => {
        if (formToDelete) formToDelete.submit();
    });
</script>
@endsection
