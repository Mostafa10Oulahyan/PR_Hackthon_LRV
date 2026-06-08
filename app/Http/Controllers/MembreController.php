<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;
use App\Events\NotificationSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembreController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $mesEmprunts = Emprunt::with('livre')->where('id_user', $user->id)->latest()->take(5)->get();
        $livresDisponibles = Livre::where('nombre_exemplaires', '>', 0)->take(6)->get();
        $totalEmprunts = Emprunt::where('id_user', $user->id)->count();
        $empruntsEnCours = Emprunt::where('id_user', $user->id)->whereIn('statut', ['En cours', 'Accepté'])->count();
        $empruntsEnAttente = Emprunt::where('id_user', $user->id)->where('statut', 'En attente')->count();

        return view('membre.dashboard', compact(
            'user', 'mesEmprunts', 'livresDisponibles', 'totalEmprunts', 'empruntsEnCours', 'empruntsEnAttente'
        ));
    }

    public function livres()
    {
        $livres = Livre::with(['emprunts' => function ($q) {
            $q->whereIn('statut', ['Accepté', 'En cours'])->orderBy('date_retour_prevue', 'asc');
        }])->get();
        return view('membre.livres', compact('livres'));
    }

    public function createEmprunt(Request $request)
    {
        $livres = Livre::where('nombre_exemplaires', '>', 0)->get();
        $selectedLivre = $request->query('livre_id') ? Livre::find($request->query('livre_id')) : null;
        return view('membre.createEmprunt', compact('livres', 'selectedLivre'));
    }

    public function storeEmprunt(Request $request)
    {
        $request->validate([
            'id_livre' => 'required|exists:livres,id',
            'date_emprunt' => 'required|date',
            'date_retour_prevue' => 'required|date|after_or_equal:date_emprunt',
        ]);

        $livre = Livre::findOrFail($request->id_livre);
        if ($livre->nombre_exemplaires <= 0) {
            return back()->withErrors(['id_livre' => 'Ce livre n\'est plus disponible.']);
        }

        // Calculate and validate borrow duration
        $dateEmprunt = \Carbon\Carbon::parse($request->date_emprunt);
        $dateRetour = \Carbon\Carbon::parse($request->date_retour_prevue);
        $diffDays = $dateEmprunt->diffInDays($dateRetour);

        if ($diffDays > $livre->duration_borrow) {
            return back()->withErrors([
                'date_retour_prevue' => "La durée d'emprunt maximale autorisée pour ce livre est de {$livre->duration_borrow} jours (votre demande : {$diffDays} jours)."
            ])->withInput();
        }

        Emprunt::create([
            'id_livre' => $request->id_livre,
            'id_user' => Auth::id(),
            'date_emprunt' => $request->date_emprunt,
            'date_retour_prevue' => $request->date_retour_prevue,
            'statut' => 'En attente',
        ]);

        // Notify admin about new borrow request
        try {
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                $notification = AppNotification::create([
                    'user_id' => $admin->id,
                    'type' => 'new_borrow',
                    'title' => 'Nouvelle Demande 📚',
                    'message' => Auth::user()->name . ' a demandé l\'emprunt de "' . $livre->titre . '".',
                    'icon' => 'info',
                ]);
                broadcast(new NotificationSent($notification))->toOthers();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Notification error: ' . $e->getMessage());
        }

        return redirect()->route('membre.mesEmprunts')->with('success', 'Demande d\'emprunt soumise avec succès. En attente d\'approbation.');
    }

    public function mesEmprunts()
    {
        $emprunts = Emprunt::with('livre')->where('id_user', Auth::id())->orderBy('id', 'desc')->get();
        return view('membre.mesEmprunts', compact('emprunts'));
    }

    public function profil()
    {
        $user = Auth::user();
        $totalEmprunts = Emprunt::where('id_user', $user->id)->count();
        $empruntsEnCours = Emprunt::where('id_user', $user->id)->whereIn('statut', ['En cours', 'Accepté'])->count();
        return view('membre.profil', compact('user', 'totalEmprunts', 'empruntsEnCours'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $user = Auth::user();
        $avatarPath = $this->uploadToCloudinary($request->file('avatar'));

        if ($avatarPath) {
            $user->update(['image_profile' => $avatarPath]);
            return back()->with('success', 'Votre avatar a été mis à jour avec succès !');
        }

        return back()->withErrors(['avatar' => 'Le téléversement de l\'avatar a échoué.']);
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
}
