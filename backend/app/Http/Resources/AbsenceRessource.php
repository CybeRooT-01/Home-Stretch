<?php

namespace App\Http\Resources;

use App\Models\Etudiant;
use App\Models\SessionCours;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsenceRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "etudiant" => new EtudiantRessource(Etudiant::where('id', $this->etudiant_id)->first()),
            "sessioncours" => new SessionCoursRessource(SessionCours::where('id', $this->session_id)->first()),

        ];
    }
}
