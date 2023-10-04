<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionCours extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'cours_id',
        'classe_id',
        'salle_id',
        'date',
        'heure_debut',
        'heure_fin',
        'validee'
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
