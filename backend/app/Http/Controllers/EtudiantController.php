<?php

namespace App\Http\Controllers;

use App\Http\Requests\InscriptionRequests;
use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EtudiantController extends Controller
{
    public function inscription(Request $request)
    {
        $etudiants = [];
        $inscriptions = [];
        $inscriptionsErronees = [];

        foreach ($request->json() as $eleve) {
            $classeId = $eleve['classe_id'];
            $classe = Classe::find($classeId);
            if (!$classe) {
                $inscriptionsErronees[] = [
                    "eleve" => $eleve,
                    "message" => "La classe n'a pas été trouvée"
                ];
                continue;
            }

            if ($classe->etat == false) {
                $inscriptionsErronees[] = [
                    "eleve" => $eleve,
                    "message" => "La classe n'est pas encore ouverte"
                ];
                continue;
            }

            DB::beginTransaction();
            try {
//                $user = User::updateOrCreate(
//                    ['login' => $eleve['email']],
//                    [
//                        "nom" => $eleve['nomComplet'],
//                        "login" => $eleve['email'],
//                        "password" => "password",
//                        "role_id" => 3,
//                        "email" => $eleve['email'],
//                    ]
//                );
                $user = User::where('nom', $eleve['nomComplet'])->first();
                if (!$user) {
                    $user = User::create([
                        "nom" => $eleve['nomComplet'],
                        "login" => $eleve['email'],
                        "password" => "password",
                        "role_id" => 3,
                        "email" => $eleve['email'],
                    ]);
                }else{
                    $user->update([
                        "nom" => $eleve['nomComplet'],
                        "login" => $eleve['email'],
                        "password" => "password",
                        "role_id" => 3,
                        "email" => $eleve['email'],
                    ]);
                }
                $etudiant = Etudiant::where('matricule', $eleve['matricule'])->first();
                if (!$etudiant) {
                    $etudiant = Etudiant::create([
                        'user_id' => $user->id,
                        "nomComplet" => $eleve['nomComplet'],
                        "email" => $eleve['email'],
                        "matricule" => $eleve['matricule'],
                    ]);
                }else{
                    $etudiant->update([
                        'user_id' => $user->id,
                        "nomComplet" => $eleve['nomComplet'],
                        "email" => $eleve['email'],
                        "matricule" => $eleve['matricule'],
                    ]);
                }
                $inscription = Inscription::create([
                    "etudiant_id" => $etudiant->id,
                    "annee_id" => $eleve['annee_id'],
                    "classe_id" => $eleve['classe_id'],
                ]);
                $etudiants[] = $etudiant;
                $inscriptions[] = $inscription;

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                $inscriptionsErronees[] = [
                    "eleve" => $eleve,
                    "message" => "Erreur d'inscription : " . $e->getMessage(),
                ];
            }
        }
        return response()->json([
            "message" => "Inscriptions effectuées avec succès",
            "etudiants" => $etudiants,
            "inscriptions" => $inscriptions,
            "inscriptions_erronees" => $inscriptionsErronees,
            "status" => 201
        ]);
    }

//    public function inscription(Request $request)
//    {
//        $etudiants = [];
//        $inscriptions = [];
//        $inscriptionsErronees = [];
//
//        foreach ($request->json() as $eleve) {
//            $classeId = $eleve['classe_id'];
//            $classe = Classe::find($classeId);
//            if (!$classe) {
//                $inscriptionsErronees[] = [
//                    "eleve" => $eleve,
//                    "message" => "La classe n'a pas été trouvée"
//                ];
//                continue;
//            }
//
//            if ($classe->etat == false) {
//                $inscriptionsErronees[] = [
//                    "eleve" => $eleve,
//                    "message" => "La classe n'est pas encore ouverte"
//                ];
//                continue;
//            }
//
//            DB::beginTransaction();
//            try {
//                $etudiant = Etudiant::create([
//                    "nomComplet" => $eleve['nomComplet'],
//                    "email" => $eleve['email'],
//                    "matricule" => $eleve['matricule'],
//
//                ]);
//                $inscription = Inscription::create([
//                    "etudiant_id" => $etudiant->id,
//                    "annee_id" => $eleve['annee_id'],
//                    "classe_id" => $eleve['classe_id'],
//                ]);
//                User::create([
//                    "nom" => $eleve['nomComplet'],
//                    "login" => $eleve['email'],
//                    "password" => "password",
//                    "role_id" => 3,
//                    "email" => $eleve['email'],
//                ]);
//                $etudiants[] = $etudiant;
//                $inscriptions[] = $inscription;
//
//                DB::commit();
//
//            } catch (\Exception $e) {
//                DB::rollBack();
//                $inscriptionsErronees[] = [
//                    "eleve" => $eleve,
//                    "message" => "Erreur d'inscription : " . $e->getMessage(),
//                ];
//            }
//        }
//        return response()->json([
//            "message" => "Inscriptions effectuées avec succès",
//            "etudiants" => $etudiants,
//            "inscriptions" => $inscriptions,
//            "inscriptions_erronees" => $inscriptionsErronees,
//            "status" => 201
//        ]);
//    }
}
