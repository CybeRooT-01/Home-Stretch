<?php

namespace App\Http\Controllers;

use App\Http\Resources\CoursRessources;
use App\Models\Cours;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::all();
        return response()->json(CoursRessources::collection($cours), 200);
    }
}
