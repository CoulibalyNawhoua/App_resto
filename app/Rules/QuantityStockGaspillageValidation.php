<?php

namespace App\Rules;

use Closure;
use App\Models\Conversion;
use App\Models\StockProduit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\ValidationRule;

class QuantityStockGaspillageValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $index = explode('.', $attribute)[1];

        $productStockId = request()->input("products.{$index}");

        $operation_id = request()->input("type_ajustement.{$index}");

        $quantite = request()->input("quantite.{$index}");

        $product_unit = request()->input("unite.{$index}");

        $depot_id = Auth::user()->entite_id;


        $stockP = StockProduit::where('id', 1)->first();


        // $product = Produit::where('id', $stockP->produit_id)->first();


        $conversion = Conversion::where([
                        ['unite_depart_id','=', $stockP->unite_id],
                        ['unite_arrivee_id','=', $product_unit]
                    ])->first();

        // $stockP = StockProduit::where([
        //     ['produit_id', '=', $product_id],
        //     ['entite_id', '=', $depot_id],
        //     ['unite_id', $product_unit]
        // ])->first();

        // $operation = TypeAjustement::where('id', $operation_id)->first();

        if (is_null($conversion)){

            $fail('Erreur!');
            // if($operation->type && $operation_id && ($operation->type->code == 'output')){
            //     if ($stockP->quantite <= 0 || $quantite > $stockP->quantite){
            //         $fail('L\'opération entraînera un stock négatif pour le produit '.$stockP->produit->nom_produit.' .');
            //     }
            // }
        }
    }
}
