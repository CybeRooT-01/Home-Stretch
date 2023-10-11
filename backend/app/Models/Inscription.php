<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "etudiant_id",
        "annee_id",
        "classe_id",
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
