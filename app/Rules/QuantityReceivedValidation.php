<?php

namespace App\Rules;

use App\Models\Produit;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class QuantityReceivedValidation implements ValidationRule
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

        $mark_received = request()->input("mark_received.{$index}");

        $quantite = request()->input("quantite.{$index}");

        $product = Produit::where('id',$product_id)->first();

        if ($mark_received == 1 && $quantite < 1){
            $fail('la quantité '.$product->nom_produit.' saisie est invalide, s\'il vous plait entrez une quantité supérieure à 0.');
        }
    }
}
