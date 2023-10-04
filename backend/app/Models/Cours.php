<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cours extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'quota_horaire_globale',
        'module_id',
        'professeur_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
}
