@extends('layouts.app')

@section('title', 'Nouvel Emprunt - BiblioTech Cloud')

@section('content')
<style>
    .form-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        background: linear-gradient(to right, var(--text-main), var(--text-muted));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-group {
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-main);
        letter-spacing: 0.3px;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--card-border);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        color: var(--text-main);
        font-family: inherit;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-glow);
        background: rgba(255, 255, 255, 0.08);
    }

    .text-danger {
        color: var(--danger);
        font-size: 0.85rem;
        font-weight: 500;
        margin-top: 0.25rem;
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        border-top: 1px solid var(--card-border);
        padding-top: 1.5rem;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-main);
        border: 1px solid var(--card-border);
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
    }
</style>

<div class="form-header">
    <h1 class="page-title">Enregistrer un Nouvel Emprunt</h1>
    <p style="color: var(--text-muted); margin-top: 0.25rem;">Remplissez les détails pour associer un livre à un membre.</p>
</div>

<div class="glass-card" style="max-width: 650px; margin: 0 auto;">
    <form action="{{ route('emprunts.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="id_livre">Sélectionner le Livre</label>
            <select name="id_livre" id="id_livre" class="form-control" required>
                <option value="" disabled selected>-- Choisir un livre --</option>
                @foreach($livres as $livre)
                    <option value="{{ $livre->id }}" {{ old('id_livre') == $livre->id ? 'selected' : '' }} {{ $livre->nombre_exemplaires <= 0 ? 'disabled' : '' }}>
                        {{ $livre->titre }} (ISBN: {{ $livre->isbn }}) - [Exemplaires: {{ $livre->nombre_exemplaires }}]
                    </option>
                @endforeach
            </select>
            @error('id_livre')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_membre">Sélectionner le Membre</label>
            <select name="id_membre" id="id_membre" class="form-control" required>
                <option value="" disabled selected>-- Choisir un membre --</option>
                @foreach($membres as $membre)
                    <option value="{{ $membre->id }}" {{ old('id_membre') == $membre->id ? 'selected' : '' }}>
                        {{ $membre->prenom }} {{ $membre->nom }} ({{ $membre->email }})
                    </option>
                @endforeach
            </select>
            @error('id_membre')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_emprunt">Date d'Emprunt</label>
            <input type="date" name="date_emprunt" id="date_emprunt" class="form-control" value="{{ old('date_emprunt', date('Y-m-d')) }}" required>
            @error('date_emprunt')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_retour_prevue">Date de Retour Prévue</label>
            <input type="date" name="date_retour_prevue" id="date_retour_prevue" class="form-control" value="{{ old('date_retour_prevue', date('Y-m-d', strtotime('+10 days'))) }}" required>
            @error('date_retour_prevue')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="button-group">
            <a href="{{ route('emprunts.index') }}" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                Enregistrer l'emprunt
            </button>
        </div>
    </form>
</div>
@endsection
