<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Http\JsonResponse;

class InscriptionController extends Controller
{
    public function index():jsonResponse{
        return response()->json(Inscription::all(),200);
    }

}
