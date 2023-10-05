<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfesseurController extends Controller
{
    public function index():jsonResponse
    {
        return response()->json(Professeur::all(),200);
    }
}
