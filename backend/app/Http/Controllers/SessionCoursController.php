<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanificationCoursRequest;
use App\Http\Resources\CoursRessources;
use App\Http\Resources\InscriptionRessource;
use App\Http\Resources\SessionCoursRessource;
use App\Mail\AcceptationAnnulationCour;
use App\Mail\AvertissementFuyardMail;
use App\Mail\ConvoquationFuyardMail;
use App\Models\Absence;
use App\Models\Cours;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Salle;
use App\Models\SessionCours;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SessionCoursController extends Controller
{
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', SessionCours::class);
        $sessionCour = SessionCoursRessource::collection(SessionCours::all()->where('validee', false));
        return response()->json($sessionCour, 200);
    }

    public function store(PlanificationCoursRequest $request)
    {
        $this->authorize('create', SessionCours::class);
        $coursId = $request->input('cour_id');
        $salleId = $request->input('salle_id');
        $classeIds = (array)$request->input('classe_id');
        $date = $request->input('date');
        $heureDebut = $request->input('heure_debut');
        $heureFin = $request->input('heure_fin');
        $enligne = $request->input('enligne');

        $inscriptions = Inscription::whereIn('classe_id', $classeIds)->get();

        if (count($classeIds) < 1) {
            return response()->json([
                'message' => "Aucune classe spécifiée",
            ], 400);
        }

        // Vérification commune
        $salle = Salle::find($salleId);
        $cours = Cours::find($coursId);
        $nombreInscritPourCetteClasse = count($inscriptions);
        $nombreDePlaceDansLaSalle = $salle->capacite;
        if (!$enligne){
            if ($nombreInscritPourCetteClasse > $nombreDePlaceDansLaSalle) {
                return response()->json([
                    'message' => "La salle ne peut pas contenir tous les étudiants de cette classe",
                ], 400);
            }
        }


        if ($heureDebut >= $heureFin) {
            return response()->json([
                'message' => "L'heure de début doit être inférieur à l'heure de fin",
            ], 400);
        }

        // Vérification commune pour les cours chevauchés
        $coursChevauches = SessionCours::where('date', $date)
            ->where('salle_id', $salleId)
            ->whereIn('classe_id', $classeIds)
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

        // Vérification du quota horaire pour une seule classe
        $quotaHoraireGlobale = (int)$cours->quota_horaire_globale;
        $quotaHoraireDejaPlanifie = 0;
        $CoursPlanifies = SessionCours::where('cours_id', $coursId)
            ->whereIn('classe_id', $classeIds)
            ->get();
        foreach ($CoursPlanifies as $coursPlanifie) {
            $quotaHoraireDejaPlanifie += (int)$coursPlanifie->heure_fin - (int)$coursPlanifie->heure_debut;
        }

        if ($quotaHoraireDejaPlanifie + ((int)$heureFin - (int)$heureDebut) > $quotaHoraireGlobale) {
            return response()->json([
                'message' => "Le quota horaire globale est atteint pour ce cours",
            ], 400);
        }


        // Vérification de la disponibilité du professeur (commune)
        $professeur = $cours->professeur;
        $coursPlanifies = SessionCours::where('date', $date)
            ->where('heure_debut', $heureDebut)
            ->where('heure_fin', $heureFin)
            ->get();

        foreach ($coursPlanifies as $coursPlanifie) {
            if ($coursPlanifie->cours->professeur->id == $professeur->id) {
                return response()->json([
                    'message' => "Le professeur n'est pas disponible",
                ], 400);
            }
        }

        if (count($classeIds) == 1) {
            // Si une seule classe est spécifiée
            $sessionplanifie = SessionCours::create([
                'cours_id' => $coursId,
                'classe_id' => $classeIds[0],
                'salle_id' => $salleId,
                'date' => $date,
                'heure_debut' => $heureDebut,
                'heure_fin' => $heureFin,
                'validee' => false
            ]);

            return response()->json([
                'message' => "Cours planifié avec succès",
                'session' => new SessionCoursRessource($sessionplanifie),
            ]);
        } else {
            // Si plusieurs classes sont spécifiées
            $plan = [];
            foreach ($classeIds as $classeId) {
                $plan[] = [
                    'date' => $date,
                    'heure_debut' => $heureDebut,
                    'heure_fin' => $heureFin,
                    'salle_id' => $salleId,
                    'cours_id' => $coursId,
                    'classe_id' => $classeId,
                ];
            }

            SessionCours::insert($plan);

            return response()->json([
                'message' => "Cours planifié avec succès",
            ]);
        }
    }


    public function update(string $id)
    {
        $sessionCours = SessionCours::find($id);
        $this->authorize('update', $sessionCours);
        if (!$sessionCours) {
            return response()->json([
                'message' => "session cours non trouvé",
            ], 404);
        }

        if ($sessionCours->validee) {
            return response()->json([
                'message' => "session cours deja validée",
            ], 400);
        }

        //reduire le quota horaire globale
        $heureDebut = Carbon::parse($sessionCours->heure_debut);
        $heureFin = Carbon::parse($sessionCours->heure_fin);
        $duree = $heureDebut->diff($heureFin);
        $dureeh = $duree->h;
        $dureem = $duree->i;
        $duree = $dureeh + $dureem / 60; //la duree du cours en heure
        $date = $sessionCours->date;
        $salle = $sessionCours->salle;
        $cour = $sessionCours->cours;
        $cours = Cours::find($sessionCours->cours_id);
        $quotaHoraireGlobale = (int)$cours->quota_horaire_globale;
        $quotaHoraireGlobale = $quotaHoraireGlobale - $duree;
        $cours->quota_horaire_globale = $quotaHoraireGlobale;
        $cours->save();
        //ici on gere les absences
        $classe = $sessionCours->classe;
        $inscrits = Inscription::all()->where('classe_id', $classe->id);
        $etudiantDeLaClasseNonEmarge = [];
        //on verifie si les etudiants de cette classe ont marqués leurs présences
        foreach ($inscrits as $inscrit) {
            $etudiantDeLaClasse = $inscrit->etudiant;
            //si l'etudiant n'a pas marqué sa presence
            $absence = Absence::where('session_id', $id)->where('etudiant_id', $etudiantDeLaClasse->id)->where('date', $date)->first();
            if ($absence == null) {
                $etudiantDeLaClasseNonEmarge[] = $etudiantDeLaClasse;
            }
        }
        //inserer les absences
        foreach ($etudiantDeLaClasseNonEmarge as $etudiant) {
            $fantome = Absence::create([
                'session_id' => $id,
                'etudiant_id' => $etudiant->id,
                'date' => $date,
            ]);
            $fantome->total_heurs_absance += $duree;
            $fantome->save();
        }

        $SessionEnMemeTemps = SessionCours::where('date', $date)
            ->where('salle_id', $salle->id)
            ->where('cours_id', $cour->id)
            ->where('heure_debut', $sessionCours->heure_debut)
            ->where('heure_fin', $sessionCours->heure_fin)
            ->where('date', $sessionCours->date)
            ->where('validee', false)
            ->get();
        foreach ($SessionEnMemeTemps as $session) {
            $classeEnMemeTemps = $session->classe;
            $inscritsEnMMtemps = Inscription::all()->where('classe_id', $classeEnMemeTemps->id);
            $etudiantDeLaClasseNonEmargeEnMemeTemps = [];
            foreach ($inscritsEnMMtemps as $inscrit) {
                $etudiantDeLaClasseEnMemeTemps = $inscrit->etudiant;
                $absenceEnMemeTemps = Absence::where('session_id', $session->id)->where('etudiant_id', $etudiantDeLaClasseEnMemeTemps->id)->where('date', $date)->first();
                if ($absenceEnMemeTemps == null) {
                    $etudiantDeLaClasseNonEmargeEnMemeTemps[] = $etudiantDeLaClasseEnMemeTemps;
                }
            }
            //inserer les absences
            foreach ($etudiantDeLaClasseNonEmargeEnMemeTemps as $etudiant) {
                $fantomeEnMmTemps = Absence::create([
                    'session_id' => $session->id,
                    'etudiant_id' => $etudiant->id,
                    'date' => $date,
                ]);
                $fantomeEnMmTemps->total_heurs_absance += $duree;
                $fantomeEnMmTemps->save();
                $idFantome = $fantomeEnMmTemps->etudiant_id;
                $etudiantFantomeEnmmTmps = Etudiant::where('id', $idFantome)->first();
                $emailetudiantFantomeEnmmTmps = $etudiantFantomeEnmmTmps->email;
                if ($fantomeEnMmTemps->total_heurs_absance >= 30) {
                    $mail = new ConvoquationFuyardMail();
                    $mail->to($emailetudiantFantomeEnmmTmps);
                    Mail::send($mail);
                } elseif ($fantomeEnMmTemps->total_heurs_absance >= 10) {
                    $mail = new AvertissementFuyardMail();
                    $mail->to($emailetudiantFantomeEnmmTmps);
                    Mail::send($mail);
                }
            }
            $session->validee = true;
            $session->save();
        }
        $eleveAbsent = Absence::where('session_id', $id)->where('presence', false)->get();
        foreach ($eleveAbsent as $fuyard) {
            $id_etudiantFuyard = $fuyard->etudiant_id;
            $etudiantFuyard = Etudiant::where('id', $id_etudiantFuyard)->first();
            $emailDuFuyaard = $etudiantFuyard->email;
            $fuyard->total_heurs_absance += $duree;
            if ($fuyard->total_heurs_absance >= 30) {
                $mail = new ConvoquationFuyardMail();
                $mail->to($emailDuFuyaard);
                Mail::send($mail);
            } elseif ($fuyard->total_heurs_absance >= 10) {
                $mail = new AvertissementFuyardMail();
                $mail->to($emailDuFuyaard);
                Mail::send($mail);
            }
        }
        return response()->json([
            'message' => "session cours validée avec succès",
        ]);
    }
}
