<?php

namespace App\Http\Controllers;

use App\Http\Requests\SallePostRequest;
use App\Models\Salle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    public function index():jsonResponse
    {
        $this->authorize('viewAny', Salle::class);
        $salles = Salle::all();
        return response()->json($salles,200);
    }

    public function store(SallePostRequest $request){
        $this->authorize('viewAny', Salle::class);
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
