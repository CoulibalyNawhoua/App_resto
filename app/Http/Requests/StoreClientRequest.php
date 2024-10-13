<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nom' => 'required',
            'categorie_client_id' => 'required',
            'prenom' => 'required',
            'telephone_personnel' => 'required',
            'localisation' => 'required',
        ];
    }
}
