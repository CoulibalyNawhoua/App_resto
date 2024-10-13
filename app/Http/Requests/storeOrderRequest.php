<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeOrderRequest extends FormRequest
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
            'product_count'=> 'gt:0',
            // 'quantite.*'=> 'required|gte:1|lte:quantite_stock.*|numeric|min:1',
            'quantite.*'=> 'required|gte:1|numeric|min:1',
            'montant_recu'=>'numeric'
        ];
    }


    public function messages(): array
    {
        return [
            'product_count.gt' => 'Impossible de procéder aucun produit n\'a été fourni.',
            'quantite.*.required' => 'Le champ quantité à la ligne :position  est obligatoire.',
            'quantite.*.gte' => 'Le champ quantité à la ligne :position  est incorrect.',
            'quantite.*.lte' => 'La quantité saisie à la ligne :position doit être inférieur ou égale à la quantité disponible en stock.',
            'quantite.*.numeric'=> 'La quantité de saisie à la ligne :position doit être un nombre valide.',
            'quantite.min'=> 'La quantité de saisie à la ligne :position doit être Supérieur ou égale a (1).',
            'montant_recu.numeric'=> 'montant invalide, veuillez saisir un montant valide svp.',
        ];
    }
}
