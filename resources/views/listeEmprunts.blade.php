@extends('layouts.app')

@section('title', 'Liste des Emprunts - BiblioTech Cloud')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    th {
        padding: 1.25rem 1rem;
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--card-border);
    }

    td {
        padding: 1.25rem 1rem;
        font-size: 0.95rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        color: var(--text-main);
    }

    tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-pending {
        background-color: var(--warning-bg);
        color: var(--warning);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .badge-returned {
        background-color: var(--success-bg);
        color: var(--success);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-muted);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1.5rem;
        color: rgba(99, 102, 241, 0.4);
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Tableau de Bord des Emprunts</h1>
        <p style="color: var(--text-muted); margin-top: 0.25rem;">Gérer les emprunts et les retours de livres</p>
    </div>
    <a href="{{ route('emprunts.create') }}" class="btn-primary">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Nouvel Emprunt
    </a>
</div>

<div class="glass-card">
    <div class="table-container">
        @if($emprunts->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Livre</th>
                        <th>Membre</th>
                        <th>Date d'Emprunt</th>
                        <th>Date de Retour Prévue</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emprunts as $emprunt)
                        <tr>
                            <td style="font-weight: 700; color: var(--primary);">#{{ $emprunt->id }}</td>
                            <td style="font-weight: 600;">{{ $emprunt->livre->titre }}</td>
                            <td>{{ $emprunt->membre->prenom }} {{ $emprunt->membre->nom }}</td>
                            <td>{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($emprunt->date_retour_prevue)->format('d/m/Y') }}</td>
                            <td>
                                @if($emprunt->statut === 'En cours')
                                    <span class="badge badge-pending">En cours</span>
                                @else
                                    <span class="badge badge-returned">Retourné</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-icon">📂</div>
                <h3>Aucun emprunt trouvé</h3>
                <p style="margin-top: 0.5rem;">Commencez par ajouter un nouvel emprunt de livre dans le système.</p>
            </div>
        @endif
    </div>
</div>
@endsection
