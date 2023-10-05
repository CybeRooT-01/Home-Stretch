<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanificationCoursRequest;
use App\Http\Resources\CoursRessources;
use App\Http\Resources\SessionCoursRessource;
use App\Models\Cours;
use App\Models\Inscription;
use App\Models\Salle;
use App\Models\SessionCours;
use Illuminate\Http\JsonResponse;

class SessionCoursController extends Controller
{
    public function index():JsonResponse
    {
        $sessionCour = SessionCoursRessource::collection(SessionCours::all());
        return response()->json($sessionCour,200);
    }

    public function store(PlanificationCoursRequest $request)
    {
        $coursId = $request->input('cour_id');
        $salleId = $request->input('salle_id');
        $classeId = $request->input('classe_id');
        $date = $request->input('date');
        $heureDebut = $request->input('heure_debut');
        $heureFin = $request->input('heure_fin');
        $inscriptions = Inscription::all()->where('classe_id', $classeId);

        //verifier si la salle peut contenir tous les étudiants de cette classe
        $salle = Salle::find($salleId);
        $cours = Cours::find($coursId);
        $nombreInscritPourCetteClasse = count($inscriptions);
        $nombreDePlaceDansLaSalle = $salle->capacite;
        if ($nombreInscritPourCetteClasse > $nombreDePlaceDansLaSalle) {
            return response()->json([
                'message' => "La salle ne peut pas contenir tous les étudiants de cette classe",
            ], 400);
        }
        //si l'heure de début est supérieur à l'heure de fin
        if ($heureDebut >= $heureFin) {
            return response()->json([
                'message' => "L'heure de début doit être inférieur à l'heure de fin",
            ], 400);
        }
        //si y'a une heure dans cette intervalle
        $coursChevauches = SessionCours::where('date', $date)
            ->where('salle_id', $salleId)
            ->where('classe_id', $classeId)
            ->where(function ($query) use ($heureDebut, $heureFin) {
                $query->whereBetween('heure_debut', [$heureDebut, $heureFin])
                    ->orWhereBetween('heure_fin', [$heureDebut, $heureFin]);
            })
            ->get();

        if ($coursChevauches->count() > 0) {
            return response()->json([
                'message' => "Il y a un cours dans cet intervalle",
            ], 400);
        }
        //verif si le quota horaire globale est atteint
        $quotaHoraireGlobale = (int)$cours->quota_horaire_globale;
        $quotaHoraireDejaPlanifie = 0;
        $CoursPlanifies = SessionCours::all()->where('cours_id',$coursId);
        foreach ($CoursPlanifies as $coursPlanifie){
            $quotaHoraireDejaPlanifie += (int)$coursPlanifie->heure_fin - (int)$coursPlanifie->heure_debut;
        }
        if ($quotaHoraireDejaPlanifie + ((int)$heureFin - (int)$heureDebut) > (int)$quotaHoraireGlobale){
            return response()->json([
                'message'=>"Le quota horaire globale est atteint pour ce cours",
            ],400);
        }
        //verifier si le professeur est disponible
        $professeur = $cours->professeur;
        $coursPlanifies = SessionCours::all()->where('date',$date)->where('heure_debut',$heureDebut)->where('heure_fin',$heureFin);
        foreach ($coursPlanifies as $coursPlanifie){
            $coursPlanifie = new SessionCoursRessource($coursPlanifie);
            if ($coursPlanifie->cours->professeur->id == $professeur->id){
                return response()->json([
                    'message'=>"Le professeur n'est pas disponible",
                ],400);
            }
        }

        $sessionplanifie = SessionCours::create([
            'cours_id' => $coursId,
            'classe_id' => $classeId,
            'salle_id' => $salleId,
            'date' => $date,
            'heure_debut' => $heureDebut,
            'heure_fin' => $heureFin,
            'validee' => false
        ]);
        return response()->json([
            'message'=>"cours planifié avec succès",
            'session' => new SessionCoursRessource($sessionplanifie),
        ]);
    }
}
