@extends('layouts.app')

@section('title', 'Demande d\'emprunt - BiblioTech')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('membre.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-white transition-colors duration-200 mb-6 group">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Retour à l'espace membre
    </a>

    <!-- Selected Book Preview Card -->
    <div id="book-preview-card" class="glass-card rounded-2xl p-4 mb-5 relative overflow-hidden hidden">
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-teal-500 to-indigo-500"></div>
        <div class="flex items-center gap-4">
            <img id="preview-book-cover" src="" alt="Couverture"
                class="w-14 h-20 object-cover rounded-lg border border-white/10 shadow-md shrink-0">
            <div class="flex-1 min-w-0">
                <div class="text-[10px] font-bold text-teal-400 uppercase tracking-wider mb-1">Livre sélectionné</div>
                <div id="preview-book-title" class="font-outfit font-bold text-white text-sm truncate"></div>
                <div id="preview-book-isbn" class="text-xs text-gray-500 mt-0.5"></div>
                <div class="flex items-center gap-3 mt-2">
                    <span id="preview-book-duration" class="inline-flex items-center gap-1 text-[10px] font-semibold text-indigo-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span></span>
                    </span>
                    <span id="preview-book-stock" class="text-[10px] font-semibold"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>
        <h2 class="text-2xl font-outfit font-bold mb-6 bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">Nouvelle demande d'emprunt</h2>

        <form action="{{ route('membre.emprunts.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="id_livre" class="block text-sm font-medium text-gray-400 mb-1.5">Sélectionner le livre</label>
                <select id="id_livre" name="id_livre" class="w-full px-4 py-2.5 rounded-lg bg-[#0d1423] border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" required>
                    <option value="" disabled selected class="bg-[#0b0f19] text-gray-500">-- Choisir un livre --</option>
                    @foreach($livres as $livre)
                        <option value="{{ $livre->id }}"
                            data-duration="{{ $livre->duration_borrow }}"
                            data-titre="{{ $livre->titre }}"
                            data-isbn="{{ $livre->isbn }}"
                            data-stock="{{ $livre->nombre_exemplaires }}"
                            data-cover="{{ asset($livre->image ?? 'images/book_cover.png') }}"
                            class="bg-[#0b0f19] text-white"
                            {{ (old('id_livre') == $livre->id || ($selectedLivre && $selectedLivre->id == $livre->id)) ? 'selected' : '' }}>
                            {{ $livre->titre }} ({{ $livre->nombre_exemplaires }} ex. dispo — {{ $livre->duration_borrow }} j.)
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_emprunt" class="block text-sm font-medium text-gray-400 mb-1.5">Date de début d'emprunt</label>
                <input type="date" id="date_emprunt" name="date_emprunt" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200"
                    value="{{ old('date_emprunt', date('Y-m-d')) }}" required>
            </div>

            <div>
                <label for="date_retour_prevue" class="block text-sm font-medium text-gray-400 mb-1.5">Date de retour prévue</label>
                <input type="date" id="date_retour_prevue" name="date_retour_prevue" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200"
                    value="{{ old('date_retour_prevue', date('Y-m-d', strtotime('+14 days'))) }}" required>
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md hover:shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer mt-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Soumettre la demande d'emprunt
            </button>
        </form>
    </div>
</div>

<script>
    const bookSelect = document.getElementById('id_livre');
    const dateEmpruntInput = document.getElementById('date_emprunt');
    const dateRetourInput = document.getElementById('date_retour_prevue');

    function updateReturnDate() {
        const opt = bookSelect.options[bookSelect.selectedIndex];
        if (!opt || !opt.value) return;
        const duration = parseInt(opt.getAttribute('data-duration')) || 14;
        const startVal = dateEmpruntInput.value;
        if (!startVal) return;
        const limit = new Date(startVal);
        limit.setDate(limit.getDate() + duration);
        const pad = n => String(n).padStart(2, '0');
        const maxStr = `${limit.getFullYear()}-${pad(limit.getMonth() + 1)}-${pad(limit.getDate())}`;
        dateRetourInput.value = maxStr;
        dateRetourInput.min = startVal;
        dateRetourInput.max = maxStr;
    }

    function updateBookPreview() {
        const opt = bookSelect.options[bookSelect.selectedIndex];
        const card = document.getElementById('book-preview-card');

        if (!opt || !opt.value) {
            card.classList.add('hidden');
            return;
        }

        document.getElementById('preview-book-cover').src = opt.getAttribute('data-cover');
        document.getElementById('preview-book-title').textContent = opt.getAttribute('data-titre');
        document.getElementById('preview-book-isbn').textContent = 'ISBN: ' + opt.getAttribute('data-isbn');
        document.getElementById('preview-book-duration').querySelector('span').textContent =
            'Durée max: ' + opt.getAttribute('data-duration') + ' jours';
        const stock = parseInt(opt.getAttribute('data-stock'));
        const stockEl = document.getElementById('preview-book-stock');
        stockEl.textContent = stock + ' exemplaire(s) disponible(s)';
        stockEl.className = `text-[10px] font-semibold ${stock > 0 ? 'text-teal-400' : 'text-red-400'}`;

        card.classList.remove('hidden');
    }

    bookSelect.addEventListener('change', () => { updateReturnDate(); updateBookPreview(); });
    dateEmpruntInput.addEventListener('change', updateReturnDate);

    document.addEventListener('DOMContentLoaded', () => {
        updateReturnDate();
        updateBookPreview();
    });
</script>
@endsection
