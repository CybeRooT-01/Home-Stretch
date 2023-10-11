<?php

namespace App\Http\Resources;

use App\Models\Classe;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'nom' => $this->nom,
            'login' => $this->login,
            'email' => $this->email,
            'role' => $this->role->libelle,
            'professeur' => $this->professeur,
            'etudiant' => $this->etudiant,
            'classe' => $this->when($this->etudiant, function () {
                $classeId = Inscription::where('etudiant_id', $this->etudiant->id)->first()->classe_id;
                return Classe::where('id', $classeId)->first();
            }),
        ];

        return $data;
    }
}
