@extends('layouts.app')

@section('title', 'Ajouter un Livre - BiblioTech')

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
        <h2 class="text-2xl font-outfit font-bold mb-6 bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">Ajouter un nouveau livre</h2>

        <form action="{{ route('admin.livres.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="titre" class="block text-sm font-medium text-gray-400 mb-1.5">Titre du livre</label>
                <input type="text" id="titre" name="titre" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('titre') }}" required placeholder="Ex: Le Petit Prince" autofocus>
            </div>

            <div>
                <label for="isbn" class="block text-sm font-medium text-gray-400 mb-1.5">Code ISBN</label>
                <input type="text" id="isbn" name="isbn" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('isbn') }}" required placeholder="Ex: 978-2070612758">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nombre_exemplaires" class="block text-sm font-medium text-gray-400 mb-1.5">Nombre d'exemplaires</label>
                    <input type="number" id="nombre_exemplaires" name="nombre_exemplaires" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('nombre_exemplaires', 1) }}" min="1" required>
                </div>
                <div>
                    <label for="duration_borrow" class="block text-sm font-medium text-gray-400 mb-1.5">Durée max (jours)</label>
                    <input type="number" id="duration_borrow" name="duration_borrow" class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" value="{{ old('duration_borrow', 14) }}" min="1" required>
                </div>
            </div>

            <!-- Image Upload with Live Preview -->
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Image de couverture</label>
                <div class="flex items-start gap-4">
                    <!-- Preview -->
                    <div id="cover-preview-wrapper" class="w-20 h-28 rounded-xl overflow-hidden border-2 border-dashed border-white/10 bg-white/5 flex items-center justify-center flex-shrink-0 transition-all duration-200">
                        <img id="cover-preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <svg id="cover-placeholder" class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewCover(this)"
                            class="w-full px-4 py-2 rounded-lg bg-white/5 border border-white/10 text-gray-300 focus:outline-none focus:border-indigo-500 transition duration-200 text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20">
                        <p class="text-[10px] text-gray-500 mt-1.5">Laissez vide pour utiliser la couverture par défaut. JPG, PNG ou WEBP.</p>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow-md hover:shadow-lg shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer mt-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Enregistrer le livre
            </button>
        </form>
    </div>
</div>

<script>
    function previewCover(input) {
        const preview = document.getElementById('cover-preview');
        const placeholder = document.getElementById('cover-placeholder');
        const wrapper = document.getElementById('cover-preview-wrapper');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                wrapper.classList.remove('border-dashed', 'border-white/10');
                wrapper.classList.add('border-solid', 'border-indigo-500/30');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            wrapper.classList.add('border-dashed', 'border-white/10');
            wrapper.classList.remove('border-solid', 'border-indigo-500/30');
        }
    }
</script>
@endsection
