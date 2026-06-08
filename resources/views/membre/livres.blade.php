@extends('layouts.app')

@section('title', 'Catalogue des Livres - BiblioTech')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Catalogue de la bibliothèque</h1>
        <p class="text-gray-400 text-sm mt-1">Parcourez notre collection et réservez vos lectures.</p>
    </div>
    <div class="w-full sm:w-auto">
        <input type="text" id="searchInput" placeholder="Rechercher un livre..." class="w-full sm:w-64 px-4 py-2 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition duration-200" onkeyup="filterBooks()">
    </div>
</div>

<!-- Books Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="booksGrid">
    @if($livres->isEmpty())
        <div class="col-span-full text-center py-16">
            <p class="text-gray-400 text-lg">Aucun livre n'est actuellement référencé dans notre catalogue.</p>
        </div>
    @else
        @foreach($livres as $livre)
            @php
                $isFav = in_array($livre->id, $userFavorisIds);
            @endphp
            <div class="book-card glass-card rounded-2xl p-5 flex flex-col justify-between hover:-translate-y-1 hover:border-indigo-500/30 hover:shadow-indigo-500/5 transition-all duration-300 relative group" data-title="{{ strtolower($livre->titre) }}" data-isbn="{{ strtolower($livre->isbn) }}">
                <div class="absolute top-0 left-0 right-0 h-[2px] bg-indigo-500/10 group-hover:bg-indigo-500/30 transition-colors duration-300"></div>
                <div>
                    <div class="w-full aspect-[4/3] rounded-xl overflow-hidden mb-4 bg-white/5 border border-white/10 relative">
                        <img src="{{ asset($livre->image ?? 'images/book_cover.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $livre->titre }}">
                        
                        <!-- Floating Favorite Button -->
                        <button onclick="toggleFavoriteLivre({{ $livre->id }}, this)" class="absolute top-3.5 right-3.5 p-2 rounded-xl bg-black/40 hover:bg-black/60 text-gray-400 hover:text-red-500 border border-white/5 transition-all duration-200 cursor-pointer z-10 shadow-md">
                            <svg class="w-4 h-4 {{ $isFav ? 'fill-red-500 text-red-500' : 'text-gray-450' }}" fill="{{ $isFav ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-white mb-1.5 group-hover:text-indigo-400 transition-colors duration-200">{{ $livre->titre }}</h3>
                    <div class="flex flex-col gap-1 mb-6">
                        <div class="text-xs text-gray-500">ISBN: {{ $livre->isbn }}</div>
                        <div class="text-xs text-indigo-400/80 flex items-center gap-1 font-semibold">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Prêt : {{ $livre->duration_borrow }} jours
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-auto pt-4 border-t border-white/5">
                    @if($livre->nombre_exemplaires > 0)
                        <span class="text-xs font-semibold px-2.5 py-1 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">{{ $livre->nombre_exemplaires }} exemplaires</span>
                        <a href="{{ route('membre.emprunts.create', ['livre_id' => $livre->id]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow shadow-indigo-600/10 transform hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                            Emprunter
                        </a>
                    @else
                        <span class="text-xs font-semibold px-2.5 py-1 rounded bg-red-500/10 text-red-400 border border-red-500/20">Indisponible</span>
                        <button onclick="showAvailabilityModal('{{ addslashes($livre->titre) }}', {{ $livre->emprunts->map(fn($e) => ['date_retour_prevue' => \Carbon\Carbon::parse($e->date_retour_prevue)->format('d/m/Y')])->toJson() }})" class="px-3 py-1.5 rounded-lg text-xs font-bold text-gray-400 hover:text-white bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-200 cursor-pointer">
                            Infos Prêt
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>

<!-- Modal Structure -->
<div id="availabilityModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="glass-card rounded-2xl p-6 sm:p-8 max-w-md w-full relative overflow-hidden shadow-2xl">
        <!-- Accent line -->
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-red-500 to-indigo-500"></div>
        
        <!-- Close Button -->
        <button onclick="hideAvailabilityModal()" class="absolute right-4 top-4 text-gray-400 hover:text-white transition-colors duration-150 focus:outline-none cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <!-- Modal Title -->
        <div class="flex items-center gap-3 mb-4 mt-2">
            <div class="w-10 h-10 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-outfit font-bold text-white">Livre non disponible</h3>
        </div>
        
        <p class="text-sm text-gray-300 mb-5 leading-relaxed">
            Le livre "<span id="modalBookTitle" class="font-semibold text-indigo-400"></span>" est actuellement victime de son succès. Tous les exemplaires sont empruntés.
        </p>
        
        <div class="space-y-3">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Dates de retour prévues</h4>
            <div id="modalReturnsList" class="space-y-2 max-h-48 overflow-y-auto pr-1">
                <!-- Return items inserted here by JS -->
            </div>
        </div>
        
        <button onclick="hideAvailabilityModal()" class="w-full flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-white/5 border border-white/10 hover:bg-white/10 transition-all duration-200 cursor-pointer mt-6">
            Compris, fermer
        </button>
    </div>
</div>

<script>
    function filterBooks() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const cards = document.querySelectorAll('.book-card');
        
        cards.forEach(card => {
            const title = card.getAttribute('data-title');
            const isbn = card.getAttribute('data-isbn');
            
            if (title.includes(query) || isbn.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function showAvailabilityModal(title, loans) {
        document.getElementById('modalBookTitle').innerText = title;
        const list = document.getElementById('modalReturnsList');
        list.innerHTML = '';
        
        if (!loans || loans.length === 0) {
            list.innerHTML = `
                <div class="text-xs text-gray-400 py-4 text-center bg-white/[0.02] border border-white/5 rounded-xl font-medium">
                    Aucune date de retour n'est planifiée. Veuillez contacter le support.
                </div>
            `;
        } else {
            loans.forEach(loan => {
                list.innerHTML += `
                    <div class="flex justify-between items-center p-3 rounded-xl bg-white/[0.02] border border-white/5 text-xs">
                        <span class="text-gray-400 font-medium">Exemplaire n°${loans.indexOf(loan) + 1}</span>
                        <span class="font-bold text-teal-400">Retour le ${loan.date_retour_prevue}</span>
                    </div>
                `;
            });
        }
        
        document.getElementById('availabilityModal').classList.remove('hidden');
    }
    
    function hideAvailabilityModal() {
        document.getElementById('availabilityModal').classList.add('hidden');
    }

    // Toggle favorite AJAX helper
    async function toggleFavoriteLivre(bookId, btnElement) {
        try {
            const res = await fetch(`/membre/favoris/toggle/${bookId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
            const data = await res.json();
            if (data.status === 'success') {
                const svg = btnElement.querySelector('svg');
                if (data.attached) {
                    svg.classList.remove('text-gray-450');
                    svg.classList.add('fill-red-500', 'text-red-500');
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    svg.classList.remove('fill-red-500', 'text-red-500');
                    svg.classList.add('text-gray-450');
                    svg.setAttribute('fill', 'none');
                }
            }
        } catch (e) {
            console.error("Favorite toggle failed:", e);
        }
    }
</script>
@endsection
