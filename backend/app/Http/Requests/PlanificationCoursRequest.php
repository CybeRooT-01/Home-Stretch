<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanificationCoursRequest extends FormRequest
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
            "cour_id" => "required",
            "salle_id" => "required",
            "date" => "required",
            "heure_debut" => "required",
            "heure_fin" => "required",
        ];
    }
    public function messages()
    {
        return [
            "cour_id.required" => "Le cour est obligatoire",
            "salle_id.required" => "La salle est obligatoire",
            "date.required" => "La date est obligatoire",
            "heure_debut.required" => "L'heure de début est obligatoire",
            "heure_fin.required" => "L'heure de fin est obligatoire",
        ];
    }
}
