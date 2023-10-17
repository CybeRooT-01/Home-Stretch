<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassePostRequest;
use App\Models\Classe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index():jsonResponse
    {
        $this->authorize('viewAny', Classe::class);
        return response()->json(Classe::all()->where('etat',true),200);
    }
    public function store(ClassePostRequest $request){
        $this->authorize('viewAny', Classe::class);
        Classe::create([
            'libelle' => $request->libelle,
            'annee_id' => $request->annee_id,
            'filiere' => $request->filiere,
            'niveau' => $request->niveau,
        ]);

        return response()->json([
            'message' => 'Classe ajoutée avec success'
        ], 201);
    }
}
