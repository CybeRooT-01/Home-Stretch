<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursRessources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'quota_horaire_globale'=>$this->quota_horaire_globale,
            'module'=>$this->module->libelle,
            'nom_professeur'=>$this->professeur->nomComplet,
            'idProfesseur'=>$this->professeur->id,
            'specialite_professeur'=>$this->professeur->specialite,
            'grade_profeseur'=>$this->professeur->grade
        ];
    }
}
