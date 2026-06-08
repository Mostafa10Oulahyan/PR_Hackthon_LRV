@extends('layouts.app')

@section('title', 'Nouvel Emprunt - BiblioTech Cloud')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Enregistrer un Nouvel Emprunt</h1>
        <p class="text-gray-400 text-sm mt-1">Remplissez les détails pour associer un livre à un membre.</p>
    </div>
    
    <div class="glass-card rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>
        
        <form action="{{ route('emprunts.store') }}" method="POST" class="space-y-5">
            @csrf
    
            <div>
                <label for="id_livre" class="block text-sm font-medium text-gray-400 mb-1.5">Sélectionner le Livre</label>
                <select name="id_livre" id="id_livre" class="w-full px-4 py-2.5 rounded-lg bg-[#0d1423] border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" required>
                    <option value="" disabled selected class="bg-[#0b0f19] text-gray-500">-- Choisir un livre --</option>
                    @foreach($livres as $livre)
                        <option value="{{ $livre->id }}" class="bg-[#0b0f19] text-white" {{ old('id_livre') == $livre->id ? 'selected' : '' }} {{ $livre->nombre_exemplaires <= 0 ? 'disabled' : '' }}>
                            {{ $livre->titre }} (ISBN: {{ $livre->isbn }}) - [Exemplaires: {{ $livre->nombre_exemplaires }}]
                        </option>
                    @endforeach
                </select>
                @error('id_livre')
                    <span class="text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>
    
            <div>
                <label for="id_user" class="block text-sm font-medium text-gray-400 mb-1.5">Sélectionner le Membre (Utilisateur)</label>
                <select name="id_user" id="id_user" class="w-full px-4 py-2.5 rounded-lg bg-[#0d1423] border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" required>
                    <option value="" disabled selected class="bg-[#0b0f19] text-gray-500">-- Choisir un membre --</option>
                    @foreach($membres as $membre)
                        <option value="{{ $membre->id }}" class="bg-[#0b0f19] text-white" {{ old('id_user') == $membre->id ? 'selected' : '' }}>
                            {{ $membre->name }} ({{ $membre->email }})
                        </option>
                    @endforeach
                </select>
                @error('id_user')
                    <span class="text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>
    
            <div>
                <label for="date_emprunt" class="block text-sm font-medium text-gray-400 mb-1.5">Date d'Emprunt</label>
                <input type="date" name="date_emprunt" id="date_emprunt" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('date_emprunt', date('Y-m-d')) }}" required>
                @error('date_emprunt')
                    <span class="text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>
    
            <div>
                <label for="date_retour_prevue" class="block text-sm font-medium text-gray-400 mb-1.5">Date de Retour Prévue</label>
                <input type="date" name="date_retour_prevue" id="date_retour_prevue" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('date_retour_prevue', date('Y-m-d', strtotime('+10 days'))) }}" required>
                @error('date_retour_prevue')
                    <span class="text-red-400 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>
    
            <div class="flex justify-end gap-3 pt-4 border-t border-white/5 mt-6">
                <a href="{{ route('emprunts.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-gray-300 bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-200 cursor-pointer">Annuler</a>
                <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Enregistrer l'emprunt
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
