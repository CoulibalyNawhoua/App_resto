<?php

namespace App\Rules;

use App\Models\Produit;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class QuantityReceivedProcurementValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $index = explode('.', $attribute)[1];

        $data = request()->input("products.{$index}");

        $mark_received = request()->input("mark_received.{$index}");

        $quantity_received = request()->input("quantity_received.{$index}");

        $purchase_price = request()->input("purchase_price.{$index}");

        $products = explode('|',$data);

        $product_id = $products[0];

        $product = Produit::where('id', $product_id)->first();

        if ($mark_received == 'on' && $quantity_received < 1) {
            $fail('La quantité '.$product->nom_produit.' saisie n’est pas valide.');
        }
        elseif ($mark_received == 'on' && $purchase_price < 0) {
            $fail('Le prix d\'achat du produit '.$product->nom_produit.' saisie n’est pas valide.');
        }
    }
}
