<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtachePostRequest;
use App\Mail\NotifDajout;
use App\Models\Attache;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AttacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():jsonResponse
    {
        $this->authorize('viewAny', Attache::class);
        return response()->json(Attache::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AtachePostRequest $request)
    {
        $this->authorize('viewAny', Attache::class);
        DB::beginTransaction();
        try {
            $user = User::create([
                "login" => $request->login,
                "password" => $request->password,
                "email" => $request->email,
                "role_id" => 4,
                "nom" => $request->nom,
            ]);
            $attache = Attache::create([
                "user_id" => $user->id,
                "nomComplet" => $request->nom,
                "adresse" => $request->adresse,
                "telephone" => $request->telephone,
            ]);
            $poste = "Attache";
            $email = $request->email;
            $mail = new NotifDajout($request->login, $request->password, $poste);
            $mail->to($email);
            Mail::send($mail);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "Une erreur est survenue lors de la création de l'attache",
                "error" => $e->getMessage()
            ], 500);

        }
        return response()->json([
            "message" => "Attache créé avec succès",
            "professeur" => $attache
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
