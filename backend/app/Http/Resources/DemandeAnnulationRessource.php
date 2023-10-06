<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DemandeAnnulationRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "EstAccepter"=>$this->accepter,
            "sessionCours"=> new SessionCoursRessource($this->sessionCours),
            "motif"=>$this->motif,
            "professeur"=>$this->professeur,
        ];
    }
}
