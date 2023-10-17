<?php

namespace App\Http\Controllers;

use App\Http\Requests\professeurPostRequest;
use App\Mail\NotifDajout;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProfesseurController extends Controller
{
    public function index(): jsonResponse
    {
        $this->authorize('viewAny', Professeur::class);
        return response()->json(Professeur::all(), 200);
    }

    public function store(professeurPostRequest $request)
    {
        $this->authorize('viewAny', Professeur::class);
        DB::beginTransaction();
        try {
            $user = User::create([
                "login" => $request->login,
                "password" => $request->password,
                "email" => $request->email,
                "role_id" => 2,
                "nom" => $request->nom,
            ]);
            $professeur = Professeur::create([
                "user_id" => $user->id,
                "nomComplet" => $request->nom,
                "grade" => $request->grade,
                "specialite" => $request->specialite,
            ]);
            $poste = "Professeur";
            $email = $request->email;
            $mail = new NotifDajout($request->login, $request->password, $poste);
            $mail->to($email);
            Mail::send($mail);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "Une erreur est survenue lors de la création du professeur",
                "error" => $e->getMessage()
            ], 500);

        }
        return response()->json([
            "message" => "Professeur créé avec succès",
            "professeur" => $professeur
        ], 201);
    }
}
