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
}
