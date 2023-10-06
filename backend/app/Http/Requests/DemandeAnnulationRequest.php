<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemandeAnnulationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */

    public function rules(): array
    {
        return [
            "session_cours_id" => "required|exists:session_cours,id",
            "motif" => "required|string",
            "professeur_id"=> "required|exists:professeurs,id"
        ];
    }
    public function messages()
    {
        return[
            "session_cours_id.required" => "Le champ session cours est obligatoire",
            "session_cours_id.exists" => "La session cours n'existe pas",
            "motif.required" => "Le champ motif est obligatoire",
            "motif.string" => "Le champ motif doit être une chaine de caractères",
            "professeur_id.required" => "Le champ professeur est obligatoire",
            "professeur_id.exists" => "Le professeur n'existe pas",
        ];
    }
}
