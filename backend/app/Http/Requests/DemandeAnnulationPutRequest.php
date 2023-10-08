<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DemandeAnnulationPutRequest extends FormRequest
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
            'id' => 'required|exists:demande_annulations,id',
            'session_cours_id' => 'required|exists:session_cours,id',
        ];
    }

    public function messages()
    {
        return[
            "id.required" => "Le champ id est obligatoire",
            "id.exists" => "La demande d'annulation n'existe pas",
            "session_cours_id.required" => "Le champ session cours est obligatoire",
            "session_cours_id.exists" => "La session cours n'existe pas",
        ];
    }
}
