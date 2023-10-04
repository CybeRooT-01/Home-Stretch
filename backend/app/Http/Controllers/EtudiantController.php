<?php

namespace App\Http\Controllers;

use App\Http\Requests\InscriptionRequests;
use App\Models\Etudiant;
use App\Models\Inscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EtudiantController extends Controller
{
    public function inscription(Request $request)
    {
        DB::beginTransaction();
        try {
            $etudiants = [];
            $inscriptions = [];

            foreach ($request->json() as $eleve) {
                $etudiant = Etudiant::create([
                    "nomComplet" => $eleve['nomComplet'],
                    "email" => $eleve['email'],
                    "matricule" => $eleve['matricule'],
                ]);

                $inscription = Inscription::create([
                    "etudiant_id" => $etudiant->id,
                    "annee_id" => $eleve['annee_id'],
                    "classe_id" => $eleve['classe_id'],
                ]);

                $etudiants[] = $etudiant;
                $inscriptions[] = $inscription;
            }

            DB::commit();

            return response()->json([
                "message" => "Inscription effectuée avec succès",
                "etudiants" => $etudiants,
                "inscriptions" => $inscriptions,
                "status"=>201
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "Erreur d'inscription",
                "error" => $e->getMessage(),
            ], 500);
        }
    }


}
