<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\Membre;
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
        $emprunts = Emprunt::with(['livre', 'membre'])->orderBy('id', 'desc')->get();
        return response()->json($emprunts, 200);
    }

    /**
     * Register a new borrowing via API.
     */
    public function storeEmprunt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_livre' => 'required|exists:livres,id',
            'id_membre' => 'required|exists:membres,id',
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

                // Create borrowing
                $newEmprunt = Emprunt::create([
                    'id_livre' => $request->id_livre,
                    'id_membre' => $request->id_membre,
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
            $emprunt->load(['livre', 'membre']);

            return response()->json($emprunt, 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Transaction failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
