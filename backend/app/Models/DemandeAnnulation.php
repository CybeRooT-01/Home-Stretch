<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemandeAnnulation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'session_cours_id',
        'motif',
        'professeur_id',
    ];

    public function sessionCours()
    {
        return $this->belongsTo(SessionCours::class);
    }
    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
}
