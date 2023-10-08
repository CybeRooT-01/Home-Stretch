<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponsablePedagogique extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "nomComplet",
        "adresse",
        "telephone",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
