@extends('layouts.app')

@section('title', 'Modifier un Livre - BiblioTech')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-white transition-colors duration-200 mb-6 group">
        <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Retour au dashboard
    </a>

    <div class="glass-card rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>
        <h2 class="text-2xl font-outfit font-bold mb-6 bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">Modifier le livre</h2>

        <form action="{{ route('admin.livres.update', $livre->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="titre" class="block text-sm font-medium text-gray-400 mb-1.5">Titre du livre</label>
                <input type="text" id="titre" name="titre" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('titre', $livre->titre) }}" required placeholder="Ex: Le Petit Prince" autofocus>
            </div>

            <div>
                <label for="isbn" class="block text-sm font-medium text-gray-400 mb-1.5">Code ISBN</label>
                <input type="text" id="isbn" name="isbn" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('isbn', $livre->isbn) }}" required placeholder="Ex: 978-2070612758">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nombre_exemplaires" class="block text-sm font-medium text-gray-400 mb-1.5">Nombre d'exemplaires</label>
                    <input type="number" id="nombre_exemplaires" name="nombre_exemplaires" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('nombre_exemplaires', $livre->nombre_exemplaires) }}" min="0" required>
                </div>
                <div>
                    <label for="duration_borrow" class="block text-sm font-medium text-gray-400 mb-1.5">Durée max (jours)</label>
                    <input type="number" id="duration_borrow" name="duration_borrow" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('duration_borrow', $livre->duration_borrow) }}" min="1" required>
                </div>
            </div>

            <!-- Image with live preview -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Couverture du livre</label>
                <div class="flex items-start gap-4">
                    <div class="relative shrink-0">
                        <img id="cover-preview" src="{{ asset($livre->image ?? 'images/book_cover.png') }}"
                            class="w-20 h-28 object-cover rounded-xl border border-white/10 shadow-md" alt="Couverture actuelle">
                        <span id="cover-badge" class="hidden absolute -top-1.5 -right-1.5 px-1.5 py-0.5 text-[9px] font-bold bg-indigo-500 text-white rounded-full">Nouveau</span>
                    </div>
                    <div class="flex-1">
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewCover(this)"
                            class="w-full px-4 py-2 rounded-lg bg-white/5 border border-white/10 text-gray-300 focus:outline-none focus:border-indigo-500 transition duration-200 text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20">
                        <p class="text-[10px] text-gray-500 mt-1.5">Laissez vide pour conserver la couverture actuelle.</p>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md hover:shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer mt-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                Enregistrer les modifications
            </button>
        </form>
    </div>
</div>

<script>
    function previewCover(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('cover-preview').src = e.target.result;
                document.getElementById('cover-badge').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
