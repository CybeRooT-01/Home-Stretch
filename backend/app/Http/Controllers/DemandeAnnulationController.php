<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandeAnnulationRequest;
use App\Http\Resources\DemandeAnnulationRessource;
use App\Models\DemandeAnnulation;
use Illuminate\Http\Request;

class DemandeAnnulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(DemandeAnnulationRessource::collection(DemandeAnnulation::all()), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DemandeAnnulationRequest $request)
    {
       $demande =  DemandeAnnulation::create([
            "session_cours_id" => $request->session_cours_id,
            "motif" => $request->motif,
            "professeur_id" => $request->professeur_id,
        ]);
        return response()->json([
            "message" => "Demande d'annulation envoyée avec succès",
            "demande" => $demande
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
