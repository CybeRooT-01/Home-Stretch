<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    public function index():jsonResponse
    {
        $salles = Salle::all();
        return response()->json($salles,200);
    }

    public function store(Request $request){
        Salle::create([
            'nom' => $request->nom,
            'numero' => $request->numero,
            'capacite' => $request->capacite,
        ]);
        return response()->json([
            'message' => 'Salle ajoutée avec success'
        ], 201);
    }
}
