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
                        <option value="{{ $livre->id }}" data-duration="{{ $livre->duration_borrow }}" class="bg-[#0b0f19] text-white"
                            {{ (old('id_livre') == $livre->id || ($selectedLivre && $selectedLivre->id == $livre->id)) ? 'selected' : '' }}>
                            {{ $livre->titre }} (Prêt max : {{ $livre->duration_borrow }} j.)
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
            
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md hover:shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer mt-4">
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
        const selectedOption = bookSelect.options[bookSelect.selectedIndex];
        if (!selectedOption || !selectedOption.value) return;

        const duration = parseInt(selectedOption.getAttribute('data-duration')) || 14;
        const startDateVal = dateEmpruntInput.value;
        if (!startDateVal) return;

        const limitDate = new Date(startDateVal);
        limitDate.setDate(limitDate.getDate() + duration);

        const yyyy = limitDate.getFullYear();
        let mm = limitDate.getMonth() + 1;
        let dd = limitDate.getDate();

        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;

        const maxDateStr = yyyy + '-' + mm + '-' + dd;

        dateRetourInput.value = maxDateStr;
        dateRetourInput.min = startDateVal;
        dateRetourInput.max = maxDateStr;
    }

    bookSelect.addEventListener('change', updateReturnDate);
    dateEmpruntInput.addEventListener('change', updateReturnDate);

    document.addEventListener('DOMContentLoaded', () => {
        updateReturnDate();
    });
</script>
@endsection
