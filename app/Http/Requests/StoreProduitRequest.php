<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduitRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nom_produit' => 'required',
            'sous_famille_id' => 'required',
            'categorie_id' => 'required',
            'unite_id' => 'required',
            'unites.*'=> 'required',

        ];
    }
}
