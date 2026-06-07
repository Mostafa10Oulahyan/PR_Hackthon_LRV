<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpruntController extends Controller
{
    /**
     * Display a listing of the borrowings.
     */
    public function index()
    {
        $emprunts = Emprunt::with(['livre', 'membre'])->orderBy('id', 'desc')->get();
        return view('listeEmprunts', compact('emprunts'));
    }

    /**
     * Show the form for creating a new borrowing.
     */
    public function create()
    {
        $livres = Livre::where('nombre_exemplaires', '>', 0)->get();
        $membres = Membre::all();
        return view('ajouterEmprunt', compact('livres', 'membres'));
    }

    /**
     * Store a newly created borrowing in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_livre' => 'required|exists:livres,id',
            'id_membre' => 'required|exists:membres,id',
            'date_emprunt' => 'required|date',
            'date_retour_prevue' => 'required|date|after_or_equal:date_emprunt',
        ]);

        // Begin transaction to ensure consistency when updating copies count
        DB::transaction(function () use ($request) {
            $livre = Livre::findOrFail($request->id_livre);

            if ($livre->nombre_exemplaires <= 0) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['id_livre' => 'Ce livre n\'a plus d\'exemplaires disponibles pour l\'emprunt.']);
            }

            // Create the borrowing
            Emprunt::create([
                'id_livre' => $request->id_livre,
                'id_membre' => $request->id_membre,
                'date_emprunt' => $request->date_emprunt,
                'date_retour_prevue' => $request->date_retour_prevue,
                'statut' => 'En cours',
            ]);

            // Decrement copies
            $livre->nombre_exemplaires = $livre->nombre_exemplaires - 1;
            if ($livre->nombre_exemplaires == 0) {
                $livre->statut = 'Indisponible';
            }
            $livre->save();
        });

        return redirect()->route('emprunts.index')->with('success', 'L\'emprunt a été enregistré avec succès.');
    }
}
