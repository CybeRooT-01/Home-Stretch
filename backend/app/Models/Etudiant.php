<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etudiant extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "nomComplet",
        "email",
        "matricule",
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
