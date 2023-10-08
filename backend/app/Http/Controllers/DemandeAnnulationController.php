<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandeAnnulationPutRequest;
use App\Http\Requests\DemandeAnnulationRequest;
use App\Http\Resources\DemandeAnnulationRessource;
use App\Http\Resources\UserRessource;
use App\Mail\AcceptationAnnulationCour;
use App\Mail\RejetAnnulationCour;
use App\Models\DemandeAnnulation;
use App\Models\Professeur;
use App\Models\SessionCours;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DemandeAnnulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(DemandeAnnulationRessource::collection(DemandeAnnulation::all()->where("accepter", false)), 200);
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
    public function update(DemandeAnnulationPutRequest $request)
    {
        $demande = DemandeAnnulation::find($request->id);
        $sessioncour = SessionCours::find($request->session_cours_id);
        $professeu_id = $demande->professeur_id;
        $prof = Professeur::find($professeu_id);
        $user_Id = $prof->user_id;
        $user = User::find($user_Id);
        $email = $user->email;
        $mail = new AcceptationAnnulationCour();
        $mail->to($email);
        Mail::send($mail);
        $sessioncour->delete();
        $demande->accepter = true;
        $demande->save();
        return response()->json([
            "message" => "Demande d'annulation acceptée avec succès",
            "demande" => $demande
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $demande = DemandeAnnulation::find($id);
        $professeu_id = $demande->professeur_id;
        $prof = Professeur::find($professeu_id);
        $user_Id = $prof->user_id;
        $user = User::find($user_Id);
        $email = $user->email;
        $mail = new RejetAnnulationCour();
        $mail->to($email);
        Mail::send($mail);
        DemandeAnnulation::destroy($id);
    }
}
