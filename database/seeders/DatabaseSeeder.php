<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Livre;
use App\Models\Membre;
use App\Models\Emprunt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a user (standard Laravel boilerplate)
        User::factory()->create([
            'name' => 'Admin BiblioTech',
            'email' => 'admin@bibliotech.com',
        ]);

        // 2. Seed Livres
        $livre1 = Livre::create([
            'titre' => "L'Alchimiste",
            'isbn' => '978-1',
            'nombre_exemplaires' => 5,
            'statut' => 'Disponible',
        ]);

        $livre2 = Livre::create([
            'titre' => 'Le Petit Prince',
            'isbn' => '978-2',
            'nombre_exemplaires' => 2,
            'statut' => 'Disponible',
        ]);

        // 3. Seed Membres
        $membre1 = Membre::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean.dupont@email.com',
        ]);

        $membre2 = Membre::create([
            'nom' => 'Curie',
            'prenom' => 'Marie',
            'email' => 'marie.curie@email.com',
        ]);

        $membre3 = Membre::create([
            'nom' => 'Einstein',
            'prenom' => 'Albert',
            'email' => 'albert.einstein@email.com',
        ]);

        // 4. Seed Emprunts
        Emprunt::create([
            'id_livre' => $livre1->id,
            'id_membre' => $membre1->id,
            'date_emprunt' => '2026-04-10',
            'date_retour_prevue' => '2026-04-20',
            'statut' => 'En cours',
        ]);
    }
}
