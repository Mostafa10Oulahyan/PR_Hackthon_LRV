<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
use App\Events\NotificationSent;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalLivres = Livre::count();
        $totalMembres = User::where('role', 'membre')->count();
        $empruntsEnAttente = Emprunt::where('statut', 'En attente')->count();
        $empruntsEnCours = Emprunt::where('statut', 'En cours')->orWhere('statut', 'Accepté')->count();

        // Advanced metrics
        $livresDisponiblesExemplaires = Livre::sum('nombre_exemplaires');
        $livresEmpruntesExemplaires = Emprunt::whereIn('statut', ['Accepté', 'En cours'])->count();

        $topLivres = Livre::withCount('emprunts')
            ->orderBy('emprunts_count', 'desc')
            ->take(10)
            ->get();

        $empruntsParMois = Emprunt::selectRaw('MONTH(date_emprunt) as mois, COUNT(*) as total')
            ->whereYear('date_emprunt', date('Y'))
            ->whereIn('statut', ['Accepté', 'En cours'])
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->pluck('total', 'mois')
            ->all();

        $statsMois = [];
        $nomsMois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jui', 'Jut', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
        for ($i = 1; $i <= 12; $i++) {
            $statsMois[$nomsMois[$i - 1]] = $empruntsParMois[$i] ?? 0;
        }

        $leaderboard = User::where('role', 'membre')
            ->with('emprunts')
            ->orderBy('points', 'desc')
            ->get();

        $livres = Livre::latest()->take(5)->get();
        $recentEmprunts = Emprunt::with(['livre', 'user'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalLivres', 'totalMembres', 'empruntsEnAttente', 'empruntsEnCours',
            'livresDisponiblesExemplaires', 'livresEmpruntesExemplaires',
            'topLivres', 'statsMois', 'leaderboard', 'livres', 'recentEmprunts'
        ));
    }

    public function emprunts()
    {
        $emprunts = Emprunt::with(['livre', 'user'])->orderBy('id', 'desc')->get();
        return view('admin.emprunts', compact('emprunts'));
    }

    public function acceptEmprunt($id)
    {
        $emprunt = Emprunt::findOrFail($id);
        $emprunt->update(['statut' => 'Accepté']);

        $livre = Livre::find($emprunt->id_livre);
        if ($livre && $livre->nombre_exemplaires > 0) {
            $livre->nombre_exemplaires -= 1;
            if ($livre->nombre_exemplaires == 0) {
                $livre->statut = 'Indisponible';
            }
            $livre->save();
        }

        // Award +10 points to user
        $user = User::find($emprunt->id_user);
        if ($user) {
            $user->increment('points', 10);
        }

        // Send notification to the member
        $this->sendEmpruntNotification(
            $emprunt->id_user,
            'emprunt_accepted',
            'Emprunt Accepté ✅',
            'Votre demande d\'emprunt pour "' . ($livre->titre ?? 'Livre') . '" a été acceptée ! Vous pouvez récupérer le livre. Vous avez gagné +10 points de fidélité ! 🌟',
            'success'
        );

        return redirect()->route('admin.emprunts')->with('success', 'Emprunt accepté avec succès et points accordés.');
    }

    public function refuseEmprunt($id)
    {
        $emprunt = Emprunt::findOrFail($id);
        $emprunt->update(['statut' => 'Refusé']);

        $livre = Livre::find($emprunt->id_livre);
        // Send notification to the member
        $this->sendEmpruntNotification(
            $emprunt->id_user,
            'emprunt_refused',
            'Emprunt Refusé ❌',
            'Votre demande d\'emprunt pour "' . ($livre->titre ?? 'Livre') . '" a été refusée par l\'administrateur.',
            'error'
        );

        return redirect()->route('admin.emprunts')->with('success', 'Emprunt refusé.');
    }

    public function resetEmprunt($id)
    {
        $emprunt = Emprunt::findOrFail($id);
        $oldStatut = $emprunt->statut;
        $emprunt->update(['statut' => 'En attente']);

        // Adjust book inventory if changing from Accepted/In-progress
        if ($oldStatut === 'Accepté' || $oldStatut === 'En cours') {
            $livre = Livre::find($emprunt->id_livre);
            if ($livre) {
                $livre->nombre_exemplaires += 1;
                if ($livre->nombre_exemplaires > 0) {
                    $livre->statut = 'Disponible';
                }
                $livre->save();
            }
        }

        $livre = $livre ?? Livre::find($emprunt->id_livre);
        // Send notification to the member
        $this->sendEmpruntNotification(
            $emprunt->id_user,
            'emprunt_reset',
            'Emprunt Réinitialisé 🔄',
            'Votre emprunt pour "' . ($livre->titre ?? 'Livre') . '" a été réinitialisé en attente par l\'administrateur.',
            'warning'
        );

        return redirect()->route('admin.emprunts')->with('success', 'Demande d\'emprunt réinitialisée.');
    }

    public function deleteEmprunt($id)
    {
        $emprunt = Emprunt::findOrFail($id);
        $oldStatut = $emprunt->statut;
        $userId = $emprunt->id_user;
        $livre = Livre::find($emprunt->id_livre);
        $livreTitre = $livre->titre ?? 'Livre';
        $emprunt->delete();

        // Adjust book inventory if changing from Accepted/In-progress
        if ($oldStatut === 'Accepté' || $oldStatut === 'En cours') {
            if ($livre) {
                $livre->nombre_exemplaires += 1;
                if ($livre->nombre_exemplaires > 0) {
                    $livre->statut = 'Disponible';
                }
                $livre->save();
            }
        }

        // Send notification to the member
        $this->sendEmpruntNotification(
            $userId,
            'emprunt_deleted',
            'Emprunt Supprimé 🗑️',
            'Votre emprunt pour "' . $livreTitre . '" a été supprimé par l\'administrateur.',
            'error'
        );

        return redirect()->route('admin.emprunts')->with('success', 'Emprunt supprimé avec succès.');
    }

    public function createLivre()
    {
        return view('admin.createLivre');
    }

    public function storeLivre(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'isbn' => 'required|string|max:50',
            'nombre_exemplaires' => 'required|integer|min:1',
            'duration_borrow' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $imagePath = 'images/book_cover.png';
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadToCloudinary($request->file('image')) ?? 'images/book_cover.png';
        }

        Livre::create([
            'titre' => $request->titre,
            'isbn' => $request->isbn,
            'nombre_exemplaires' => $request->nombre_exemplaires,
            'duration_borrow' => $request->duration_borrow,
            'image' => $imagePath,
            'statut' => 'Disponible',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Livre ajouté avec succès.');
    }

    /**
     * Upload helper for Cloudinary using native HTTP signature upload.
     */
    private function uploadToCloudinary($file)
    {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');

        if (!$cloudName || !$apiKey || !$apiSecret) {
            // Local fallback if keys are missing
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName);
            return 'images/' . $fileName;
        }

        $timestamp = (string) time();
        $signature = sha1("timestamp=" . $timestamp . $apiSecret);

        try {
            $response = \Illuminate\Support\Facades\Http::attach(
                    'file',
                    file_get_contents($file->getRealPath()),
                    $file->getClientOriginalName()
                )
                ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                    'timestamp' => $timestamp,
                    'api_key' => $apiKey,
                    'signature' => $signature,
                ]);

            \Illuminate\Support\Facades\Log::info('Cloudinary response: ' . $response->status() . ' ' . $response->body());

            if ($response->successful()) {
                return $response->json('secure_url');
            }

            \Illuminate\Support\Facades\Log::error('Cloudinary API upload failed: ' . $response->body());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Cloudinary connection error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Helper: Create and broadcast a notification for emprunt actions.
     */
    private function sendEmpruntNotification($userId, $type, $title, $message, $icon)
    {
        try {
            $notification = AppNotification::create([
                'user_id' => $userId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'icon' => $icon,
            ]);

            broadcast(new NotificationSent($notification))->toOthers();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification broadcast error: ' . $e->getMessage());
        }
    }

    public function editLivre($id)
    {
        $livre = Livre::findOrFail($id);
        return view('admin.editLivre', compact('livre'));
    }

    public function updateLivre(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'isbn' => 'required|string|max:50',
            'nombre_exemplaires' => 'required|integer|min:0',
            'duration_borrow' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $livre = Livre::findOrFail($id);

        $data = [
            'titre' => $request->titre,
            'isbn' => $request->isbn,
            'nombre_exemplaires' => $request->nombre_exemplaires,
            'duration_borrow' => $request->duration_borrow,
        ];

        if ($request->hasFile('image')) {
            $uploadedPath = $this->uploadToCloudinary($request->file('image'));
            if ($uploadedPath) {
                $data['image'] = $uploadedPath;
            }
        }

        $data['statut'] = $request->nombre_exemplaires > 0 ? 'Disponible' : 'Indisponible';

        $livre->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Livre mis à jour avec succès.');
    }
}
