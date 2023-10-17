<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoursRequest;
use App\Http\Resources\CoursRessources;
use App\Models\Cours;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Cours::class);
        $cours = Cours::all();
        return response()->json(CoursRessources::collection($cours), 200);
    }
    public function store(CoursRequest $request){
        $this->authorize('viewAny', Cours::class);
        $quota_horaire_globale = $request->quota_horaire_globale;
        $module_id = $request->module_id;
        $professeur_id = $request->professeur_id;
        $cours = Cours::create([
            'quota_horaire_globale'=>$quota_horaire_globale,
            'module_id'=>$module_id,
            'professeur_id'=>$professeur_id
        ]);
        return response()->json(new CoursRessources($cours), 201);
    }

}
