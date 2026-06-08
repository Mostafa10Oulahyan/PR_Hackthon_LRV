<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Fetch all messages between auth user and another user.
     */
    public function fetchMessages($user_id)
    {
        $auth_id = Auth::id();

        // Mark incoming messages as read
        Message::where('sender_id', $user_id)
            ->where('receiver_id', $auth_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::with(['sender'])
            ->where(function ($query) use ($auth_id, $user_id) {
                $query->where(function ($q) use ($auth_id, $user_id) {
                    $q->where('sender_id', $auth_id)->where('receiver_id', $user_id);
                })->orWhere(function ($q) use ($auth_id, $user_id) {
                    $q->where('sender_id', $user_id)->where('receiver_id', $auth_id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $formatted = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'receiver_id' => $msg->receiver_id,
                'message' => $msg->message,
                'is_read' => (bool) $msg->is_read,
                'created_at' => $msg->created_at->toISOString(),
                'sender_name' => $msg->sender->name ?? 'Utilisateur',
            ];
        });

        return response()->json($formatted, 200);
    }

    /**
     * Send a new message.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        // Broadcast the event with fallback for Vercel/serverless environments
        try {
            broadcast(new MessageSent($msg))->toOthers();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('WebSocket broadcast failed: ' . $e->getMessage());
        }



        return response()->json([
            'id' => $msg->id,
            'sender_id' => $msg->sender_id,
            'receiver_id' => $msg->receiver_id,
            'message' => $msg->message,
            'created_at' => $msg->created_at->toISOString(),
            'sender_name' => Auth::user()->name,
        ], 201);
    }

    /**
     * Get automated virtual assistant responses based on user queries.
     */
    private function getAssistantResponse($userMessage)
    {
        $msg = mb_strtolower(trim($userMessage), 'UTF-8');

        // Greet / Help / System
        if (preg_match('/(bonjour|salut|hello|hi|aide|help|qui|assistant|systeme|fonction)/u', $msg)) {
            return "🤖 **BiblioTech AI Assistant**\n\nBonjour ! Je suis votre assistant virtuel. Je suis là pour vous aider à comprendre et naviguer dans l'application BiblioTech.\n\nVous pouvez me poser des questions sur :\n• 📚 **Recherche de livres** (tapez *'livre'*, *'chercher'*, *'disponible'*)\n• ⏱️ **Règles d'emprunts** (tapez *'emprunter'*, *'durée'*, *'rendre'*)\n• 👤 **Gestion de profil** (tapez *'profil'*, *'avatar'*, *'mot de passe'*)\n• 🔔 **Notifications & Badges** (tapez *'notification'*, *'alerte'*, *'cloche'*)\n\n*(L'administrateur a bien reçu votre message et pourra également prendre le relais pour vous répondre !)*";
        }

        // Books / Availability
        if (preg_match('/(livre|chercher|trouver|dispo|stock|recherche|book|exemplaire)/u', $msg)) {
            return "📚 **Recherche & Disponibilité des Livres**\n\n1. Rendez-vous dans l'onglet **Livres** du menu.\n2. Utilisez la barre de recherche en temps réel pour filtrer par titre, auteur ou genre.\n3. **Indicateur de Stock** : Si un livre affiche **0 exemplaire restant**, un bouton bleu **'Infos Prêt'** apparaît. Cliquez dessus pour voir qui détient le livre et la date exacte prévue pour son retour, afin de planifier votre demande !";
        }

        // Loans / Emprunts
        if (preg_match('/(emprunt|loan|rendre|retour|duree|valider|accepter|refuser)/u', $msg)) {
            return "⏱️ **Règles et Durées d'Emprunts**\n\n• **Durée standard** : Un emprunt dure **14 jours**.\n• **Processus** : Choisissez un livre et validez la demande. L'administrateur reçoit instantanément votre demande.\n• **Validation** : Dès que l'administrateur accepte ou refuse, un badge de notification s'incrémente en haut à droite, et un e-mail de confirmation vous est envoyé.";
        }

        // Profile / Avatar
        if (preg_match('/(profil|avatar|photo|image|modifier|compte|mot de passe|password)/u', $msg)) {
            return "👤 **Gestion de votre Compte**\n\n• Pour mettre à jour vos informations, allez dans l'onglet **Mon Profil**.\n• Vous pouvez y téléverser une photo de profil personnalisée (elle est hébergée sur **Cloudinary**).\n• Vous pouvez également modifier votre mot de passe en toute sécurité depuis cet écran.";
        }

        // Notifications
        if (preg_match('/(notif|alerte|cloche|badge|message|unre|non lu)/u', $msg)) {
            return "🔔 **Notifications en Temps Réel**\n\n• **Cloche en haut à droite** : Elle affiche le nombre de notifications d'emprunts non lues.\n• **Toasts** : Des alertes de succès ou d'erreur glissent depuis le côté droit de l'écran en temps réel (propulsées par WebSockets).\n• **Badge de Chat** : Un point rouge s'affiche à côté de 'Support Chat' ou sur le widget flottant dès que l'administrateur vous envoie un message.";
        }

        // Fallback
        return "🤖 **BiblioTech AI Assistant**\n\nJe n'ai pas tout à fait compris votre demande.\n\nN'hésitez pas à me demander des précisions sur :\n• 📚 **La recherche de livres**\n• ⏱️ **Les règles d'emprunts**\n• 👤 **La gestion de profil**\n• 🔔 **Les notifications**\n\n*(L'administrateur a bien reçu votre message et pourra également prendre le relais pour vous répondre !)*";
    }

    /**
     * View admin chat dashboard.
     */
    public function adminChat()
    {
        $users = User::where('role', 'membre')->get();
        return view('admin.chat', compact('users'));
    }

    /**
     * View member chat dashboard.
     */
    public function membreChat()
    {
        $admin = User::where('role', 'admin')->first() ?? User::find(1);
        return view('membre.chat', compact('admin'));
    }

    /**
     * Get unread messages count for authenticated user.
     */
    public function unreadCount()
    {
        $auth_id = Auth::id();
        
        $count = Message::where('receiver_id', $auth_id)
            ->where('is_read', false)
            ->count();
            
        $breakdown = Message::selectRaw('sender_id, count(*) as count')
            ->where('receiver_id', $auth_id)
            ->where('is_read', false)
            ->groupBy('sender_id')
            ->pluck('count', 'sender_id')
            ->toArray();

        return response()->json([
            'total' => $count,
            'breakdown' => $breakdown
        ], 200);
    }

    /**
     * Mark messages from a specific sender as read.
     */
    public function markAsRead($sender_id)
    {
        $auth_id = Auth::id();

        Message::where('sender_id', $sender_id)
            ->where('receiver_id', $auth_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true], 200);
    }
}
