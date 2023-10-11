<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsencePostRequest extends FormRequest
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
            "sessionCours_id" => "required|exists:session_cours,id",
            "etudiant_id" => "required|exists:etudiants,id",
            "date" => "required|date",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            "sessionCours_id.required" => "Le champ sessionCours_id est obligatoire",
            "sessionCours_id.exists" => "Le champ sessionCours_id doit être un id de sessionCours existant",
            "etudiant_id.required" => "Le champ etudiant_id est obligatoire",
            "etudiant_id.exists" => "Le champ etudiant_id doit être un id d'etudiant existant",
            "date.required" => "Le champ date est obligatoire",
            "date.date" => "Le champ date doit être une date",
        ];
    }
}
