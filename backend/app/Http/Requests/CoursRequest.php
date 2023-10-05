<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursRequest extends FormRequest
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
            "quota_horaire_globale" => "required|numeric",
            "module_id" => "required|exists:modules,id|numeric",
            "professeur_id" => "required|exists:professeurs,id|numeric",
        ];
    }
    public function messages()
    {
        return [
            "quota_horaire_globale.required" => "Le quota horaire globale est obligatoire",
            "module_id.required" => "Le module est obligatoire",
            "professeur_id.required" => "Le professeur est obligatoire",
            "module_id.exists" => "Le module n'existe pas",
            "professeur_id.exists" => "Le professeur n'existe pas",
            "module_id.numeric" => "Le module doit être un nombre",
            "professeur_id.numeric" => "Le professeur doit être un nombre",
        ];
    }
}
