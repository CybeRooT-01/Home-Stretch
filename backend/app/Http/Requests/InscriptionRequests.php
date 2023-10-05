<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscriptionRequests extends FormRequest
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
            "*.nomComplet" => "required|max:50",
            "*.email" => "required|email|unique:etudiants",
            "*.matricule" => "required|min:3|max:50",
            "*.annee_id" => "required",
            "*.classe_id" => "required",
        ];
    }
    public function messages(): array
    {
        return [
            "*.nomComplet.required" => "Le nom complet est obligatoire",
            "*.nomComplet.max" => "Le nom complet ne doit pas dépasser 50 caractères",
            "*.email.required" => "L'email est obligatoire",
            "*.email.email" => "L'email doit être valide",
            "*.matricule.required" => "Le matricule est obligatoire",
            "*.matricule.min" => "Le matricule doit avoir au moins 3 caractères",
            "*.matricule.max" => "Le matricule ne doit pas dépasser 50 caractères",
            "*.email.unique" => "Cet email est déjà utilisé",
            "*.annee_id.required" => "L'année est obligatoire",
            "*.classe_id.required" => "La classe est obligatoire",
        ];
    }
}
