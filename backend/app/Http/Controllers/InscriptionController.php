<?php

namespace App\Http\Controllers;

use App\Http\Resources\InscriptionRessource;
use App\Models\Inscription;
use Illuminate\Http\JsonResponse;

class InscriptionController extends Controller
{
    public function index()
    {
//        return response()->json(Inscription::all(),200);
        return InscriptionRessource::collection(Inscription::all());
    }

}
