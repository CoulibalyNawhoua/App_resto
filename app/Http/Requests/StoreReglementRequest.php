<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReglementRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mode_paiement' => 'required',
            'montant_payer' => 'required|lte:montant_restant|gte:1',
        ];
    }

    public function messages()
    {
        return [
            "mode_paiement.required" => "Veuillez sélectionner le mode de paiement",
            "montant_payer.required" => "Veuillez saisir le montant versé.",
            "montant_payer.lte" => "Le montant doit être inferieur ou égal au montant restant.",
            "montant_payer.gte" => "Veuillez saisir un montant valide.",
        ];
    }
}
