<?php

namespace App\Rules;

use App\Models\Produit;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class QuantityValidate implements ValidationRule
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

        $accepted = request()->input("accepted.{$index}");

        $quantity = request()->input("quantity.{$index}");

        $product = Produit::where('id',$product_id)->first();

        if ($accepted == 1 && $quantity < 1){
            $fail('la quantité '.$product->nom_produit.' saisie est invalide, s\'il vous plait entrez une quantité supérieure à 0.');
        }
    }
}
