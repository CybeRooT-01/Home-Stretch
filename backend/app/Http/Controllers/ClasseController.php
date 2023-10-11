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
        return response()->json(Classe::all()->where('etat',true),200);
    }
    public function store(ClassePostRequest $request){
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
