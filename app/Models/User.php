<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image_profile',
        'points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMembre(): bool
    {
        return $this->role === 'membre';
    }

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class, 'id_user');
    }

    public function favoris()
    {
        return $this->belongsToMany(Livre::class, 'favoris', 'user_id', 'livre_id')->withTimestamps();
    }

    public function getBadgeAttribute()
    {
        $pts = $this->points ?? 0;
        if ($pts < 50) {
            return [
                'name' => 'Lecteur débutant',
                'color' => 'from-amber-600/20 to-amber-700/20 border-amber-500/30 text-amber-400',
                'icon' => '🥉'
            ];
        } elseif ($pts < 150) {
            return [
                'name' => 'Lecteur régulier',
                'color' => 'from-slate-500/20 to-slate-600/20 border-slate-400/30 text-slate-300',
                'icon' => '🥈'
            ];
        } elseif ($pts < 300) {
            return [
                'name' => 'Lecteur expert',
                'color' => 'from-yellow-500/20 to-amber-600/20 border-yellow-500/30 text-yellow-400 shadow-[0_0_15px_rgba(234,179,8,0.1)]',
                'icon' => '🥇'
            ];
        } else {
            return [
                'name' => 'Maître des Livres',
                'color' => 'from-fuchsia-600/20 to-indigo-600/20 border-fuchsia-500/30 text-fuchsia-400 shadow-[0_0_15px_rgba(217,70,239,0.15)]',
                'icon' => '👑'
            ];
        }
    }
}
