<?php

namespace App\Rules;

use Closure;
use App\Models\Produit;
use App\Models\StockProduit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckIfProduitNotStock implements ValidationRule
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

        $product = Produit::where('id', $product_id)->first();

        $productStck  =  StockProduit::where('produit_id',$product->id)
                        ->where('unite_id',$product->unites_id)
                        ->where('entite_id', Auth::user()->entite_id)
                        ->first();

        if (!empty($productStck)) {
            $fail('Le produit '. $product->nom_produit.' à la ligne :position est disponible dans votre stock, veuillez mettre à jour le stocks.');
        }
    }
}
