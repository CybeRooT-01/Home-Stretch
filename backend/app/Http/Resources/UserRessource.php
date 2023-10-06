<?php

namespace App\Http\Resources;

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
//        return [
//            'id' => $this->id,
//            'nom' => $this->nom,
//            'login' => $this->login,
//            'email'=> $this->email,
//            'role' => $this->role->libelle,
//        ];
        $data = [
            'id' => $this->id,
            'nom' => $this->nom,
            'login' => $this->login,
            'email' => $this->email,
            'role' => $this->role->libelle,
            'professeur' => $this->professeur,
        ];

        return $data;
    }
}
