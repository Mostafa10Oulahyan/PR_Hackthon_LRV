<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\EmpruntController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isAdmin() 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('membre.dashboard');
    }
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/emprunts', [AdminController::class, 'emprunts'])->name('admin.emprunts');
    Route::post('/admin/emprunts/{id}/accept', [AdminController::class, 'acceptEmprunt'])->name('admin.emprunts.accept');
    Route::post('/admin/emprunts/{id}/refuse', [AdminController::class, 'refuseEmprunt'])->name('admin.emprunts.refuse');
    Route::post('/admin/emprunts/{id}/reset', [AdminController::class, 'resetEmprunt'])->name('admin.emprunts.reset');
    Route::post('/admin/emprunts/{id}/delete', [AdminController::class, 'deleteEmprunt'])->name('admin.emprunts.delete');
    Route::get('/admin/livres/create', [AdminController::class, 'createLivre'])->name('admin.livres.create');
    Route::post('/admin/livres', [AdminController::class, 'storeLivre'])->name('admin.livres.store');
    Route::get('/admin/livres/{id}/edit', [AdminController::class, 'editLivre'])->name('admin.livres.edit');
    Route::post('/admin/livres/{id}/update', [AdminController::class, 'updateLivre'])->name('admin.livres.update');
    Route::get('/admin/chat', [\App\Http\Controllers\ChatController::class, 'adminChat'])->name('admin.chat');
});

// Member Routes
Route::middleware('auth')->group(function () {
    Route::get('/membre/dashboard', [MembreController::class, 'dashboard'])->name('membre.dashboard');
    Route::get('/membre/livres', [MembreController::class, 'livres'])->name('membre.livres');
    Route::get('/membre/emprunts/create', [MembreController::class, 'createEmprunt'])->name('membre.emprunts.create');
    Route::post('/membre/emprunts', [MembreController::class, 'storeEmprunt'])->name('membre.emprunts.store');
    Route::get('/membre/mes-emprunts', [MembreController::class, 'mesEmprunts'])->name('membre.mesEmprunts');
    Route::get('/membre/profil', [MembreController::class, 'profil'])->name('membre.profil');
    Route::post('/membre/profil/avatar', [MembreController::class, 'updateAvatar'])->name('membre.profil.update_avatar');
    Route::post('/membre/favoris/toggle/{id}', [MembreController::class, 'toggleFavorite'])->name('membre.favoris.toggle');
    Route::get('/membre/chat', [\App\Http\Controllers\ChatController::class, 'membreChat'])->name('membre.chat');
    
    // Chat endpoints
    Route::get('/chat/messages/{user}', [\App\Http\Controllers\ChatController::class, 'fetchMessages'])->name('chat.messages');
    Route::post('/chat/send', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/unread-count', [\App\Http\Controllers\ChatController::class, 'unreadCount'])->name('chat.unread_count');
    Route::post('/chat/read/{sender}', [\App\Http\Controllers\ChatController::class, 'markAsRead'])->name('chat.read');

    // Notification endpoints
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread_count');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.mark_all_read');
    Route::post('/notifications/{id}/mark-read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.mark_read');
});

// Fallback/Legacy routes for compatibility
Route::get('/emprunts', [EmpruntController::class, 'index'])->name('emprunts.index');
Route::get('/emprunts/create', [EmpruntController::class, 'create'])->name('emprunts.create');
Route::post('/emprunts', [EmpruntController::class, 'store'])->name('emprunts.store');
