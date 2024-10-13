<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePvdSettingTimeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|after:heure_debut|date_format:H:i'
        ];
    }

    public function messages()
    {
        return [
            'heure_debut.required' => 'Cet champ est obligatoire',
            'heure_debut.date_format'=> 'Le formatage de l\' heure n\'est pas valide',
            'heure_fin.required' => 'Cet champ est obligatoire',
            'heure_fin.date_format' => 'Le formatage de l\' heure n\'est pas valide',
            'heure_fin.after' => 'L\'heure de fin doit être une date postérieure à l\'heure début'
        ];
    }
}
