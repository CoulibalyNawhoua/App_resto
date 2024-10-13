<?php

namespace App\Rules;

use App\Models\ProductUnit;
use App\Models\Produit;
use App\Models\StockProduit;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class CheckProductQuantite implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $index = explode('.', $attribute)[1];

        $product_id = request()->input("products.{$index}");

        $depot_deuctible_id = request()->input('depot_deuctible_id');

        $product_unit_id = request()->input("product_unit.{$index}");

        $quantity = request()->input("quantity.{$index}");

        $accepted = request()->input("accepted.{$index}");


        $productUnit = ProductUnit::where('id', $product_unit_id)->first();


        $product = Produit::where('id',$product_id)->first();

        $prodStk = StockProduit::where([
                ['entite_id','=', $depot_deuctible_id],
                ['produit_id','=',$product_id],
                // ['unite_id','=',$product_unit_id]
                ['unite_id','=',$product->unites_id]
        ])->first();


        if ($accepted == 1 && is_null($prodStk)) {
            $fail('Le produite '.$product->nom_produit.' n’est pas disponible dans votre stock');
        }

        elseif (is_null($prodStk) && $accepted == 1 && (($quantity * $productUnit->pcb) > $prodStk->quantite))
        {
            $fail('la quantité du produit '.$product->nom_produit.' demandée est supérieure à la quantité disponible en stock.');
        }


     /*   if($accepted == 1 && (($quantity * $productUnit->pcb) > $prodStk->quantite)){
            $fail('la quantité du produit '.$product->nom_produit.' demandée est supérieure à la quantité disponible en stock.');
        }*/
    }
}
