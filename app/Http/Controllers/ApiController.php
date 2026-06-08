<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    /**
     * Return list of all books.
     */
    public function getLivres()
    {
        $livres = Livre::all();
        return response()->json($livres, 200);
    }

    /**
     * Return list of all borrowings.
     */
    public function getEmprunts()
    {
        $emprunts = Emprunt::with(['livre', 'user'])->orderBy('id', 'desc')->get();
        
        $transformed = $emprunts->map(function ($emprunt) {
            $parts = explode(' ', $emprunt->user->name ?? '', 2);
            $emprunt->membre = [
                'id' => ($emprunt->id_user ?? 2) - 1,
                'nom' => $parts[1] ?? ($emprunt->user->name ?? ''),
                'prenom' => $parts[0] ?? '',
                'email' => $emprunt->user->email ?? '',
            ];
            return $emprunt;
        });

        return response()->json($transformed, 200);
    }

    /**
     * Register a new borrowing via API.
     */
    public function storeEmprunt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_livre' => 'required|exists:livres,id',
            'id_membre' => 'required|integer',
            'date_emprunt' => 'required|date',
            'date_retour_prevue' => 'required|date|after_or_equal:date_emprunt',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        try {
            $emprunt = DB::transaction(function () use ($request) {
                $livre = Livre::findOrFail($request->id_livre);

                if ($livre->nombre_exemplaires <= 0) {
                    throw new \Exception('Ce livre n\'a plus d\'exemplaires disponibles.');
                }

                // Map React member ID to database user ID
                // ID 1 -> User ID 2 (Jean Dupont)
                // ID 2 -> User ID 3 (Marie Curie)
                // ID 3 -> User ID 4 (Albert Einstein)
                $id_user = $request->id_membre + 1;

                // Create borrowing
                $newEmprunt = Emprunt::create([
                    'id_livre' => $request->id_livre,
                    'id_user' => $id_user,
                    'date_emprunt' => $request->date_emprunt,
                    'date_retour_prevue' => $request->date_retour_prevue,
                    'statut' => 'En cours',
                ]);

                // Decrement count
                $livre->nombre_exemplaires = $livre->nombre_exemplaires - 1;
                if ($livre->nombre_exemplaires == 0) {
                    $livre->statut = 'Indisponible';
                }
                $livre->save();

                return $newEmprunt;
            });

            // Load relations to return fully formed record
            $emprunt->load(['livre', 'user']);

            $parts = explode(' ', $emprunt->user->name ?? '', 2);
            $emprunt->membre = [
                'id' => ($emprunt->id_user ?? 2) - 1,
                'nom' => $parts[1] ?? ($emprunt->user->name ?? ''),
                'prenom' => $parts[0] ?? '',
                'email' => $emprunt->user->email ?? '',
            ];

            return response()->json($emprunt, 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Transaction failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Return list of all members from database.
     */
    public function getMembres()
    {
        $users = \App\Models\User::where('role', 'membre')->get();
        
        $membres = $users->map(function ($user) {
            $parts = explode(' ', $user->name ?? '', 2);
            return [
                'id' => $user->id - 1,
                'nom' => $parts[1] ?? ($user->name ?? ''),
                'prenom' => $parts[0] ?? '',
                'email' => $user->email,
            ];
        });

        return response()->json($membres, 200);
    }
}
