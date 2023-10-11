<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index():jsonResponse
    {
        return response()->json(Module::all(),200);
    }

    public function store(Request $request){
        Module::create([
            'libelle' => $request->libelle,
        ]);
        return response()->json([
            'message' => 'Module ajouté avec success'
        ], 201);
    }
}
