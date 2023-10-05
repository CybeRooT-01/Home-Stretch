<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index():jsonResponse
    {
        return response()->json(Classe::all()->where('etat',true),200);
    }
}
