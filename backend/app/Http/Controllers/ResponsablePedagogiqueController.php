<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponsablePedagogiquePostRequest;
use App\Models\ResponsablePedagogique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResponsablePedagogiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Return response()->json(ResponsablePedagogique::all(), 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResponsablePedagogiquePostRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                "login" => $request->login,
                "password" => $request->password,
                "email" => $request->email,
                "role_id" => 1,
                "nom" => $request->nom,
            ]);
            $responsablePedagogique = ResponsablePedagogique::create([
                "user_id" => $user->id,
                "nomComplet" => $request->nom,
                "adresse" => $request->adresse,
                "telephone" => $request->telephone,
            ]);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                "message" => "Une erreur est survenue lors de la création du responsable pédagogique",
                "error" => $e->getMessage()
            ], 500);

        }
        return response()->json([
            "message" => "Responsable pédagogique créé avec succès",
            "responsablePedagogique" => $responsablePedagogique
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