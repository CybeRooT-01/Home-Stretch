<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SallePostRequest extends FormRequest
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
            "nom" => "required|string |unique:salles,nom",
            "numero" => "required|integer",
            "capacite" => "required|integer",
        ];
    }

    public function messages()
    {
        return [
            "nom.required" => "Le champ nom est obligatoire",
            "nom.string" => "Le champ nom doit être une chaine de caractères",
            "numero.required" => "Le champ numero est obligatoire",
            "numero.integer" => "Le champ numero doit être un entier",
            "capacite.required" => "Le champ capacite est obligatoire",
            "capacite.integer" => "Le champ capacite doit être un entier",
            "nom.unique" => "Le nom de la salle existe déjà"
        ];
    }
}
