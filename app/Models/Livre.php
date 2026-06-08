<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    protected $table = 'livres';

    protected $fillable = [
        'titre',
        'isbn',
        'nombre_exemplaires',
        'duration_borrow',
        'image',
        'statut',
    ];

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class, 'id_livre');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favoris', 'livre_id', 'user_id')->withTimestamps();
    }
}
