<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsencePostRequest;
use App\Http\Requests\AbsencePutRequest;
use App\Http\Resources\AbsenceRessource;
use App\Models\Absence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
//        return Absence::all()->where('presence',false)->where('justifiee',false);
        $this->authorize('viewAny', Absence::class);
        return AbsenceRessource::collection(
            Absence::all()->where('presence', false)
                ->where('justifiee', false)
        );
    }
    public function store(AbsencePostRequest $request):jsonResponse
    {
        $this->authorize('create', Absence::class);
        $sessionCoursId = $request->sessionCours_id;
        $etudiantId = $request->etudiant_id;
        $date = $request->date;
        $absence = Absence::where('session_id', $sessionCoursId)->where('etudiant_id', $etudiantId)->where('date', $date)->first();
        if ($absence != null) {
            return response()->json([
                'message' => 'Vous avez deja marquée votre presence pour ce cours'
            ], 200);
        }

        Absence::create([
            'session_id' => $sessionCoursId,
            'etudiant_id' => $etudiantId,
            'date' => $date,
        ]);
        return response()->json([
            'message' => 'Presence marquée avec success'
        ], 201);
    }
    public function update(string $id):jsonResponse
    {
        $absence = Absence::find($id);
        $this->authorize('update', $absence);
        if(!$absence){
            return response()->json([
                'message' => 'Cette absence n\'existe pas'
            ], 404);
        }
        $absence->presence = true;
        $absence->save();
        return response()->json([
            'message' => 'Absence Validée'
        ], 200);
    }
}
