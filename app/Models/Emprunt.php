<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    use HasFactory;

    protected $table = 'emprunts';

    protected $fillable = [
        'id_livre',
        'id_membre',
        'date_emprunt',
        'date_retour_prevue',
        'statut',
    ];

    public function livre()
    {
        return $this->belongsTo(Livre::class, 'id_livre');
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class, 'id_membre');
    }
}
