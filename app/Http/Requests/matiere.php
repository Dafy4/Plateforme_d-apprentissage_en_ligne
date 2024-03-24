<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class matiere extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'matiere'  => 'required',
            // 'contenu_du_cour_id' => ['required', 'exists:contenu_du_cours,id'],
            'categorie_id' => ['required', 'exists:categories,id'],
            // 'proffesseur_id' => ['required', 'exists:proffesseurs,id']
        ];
    }
}
