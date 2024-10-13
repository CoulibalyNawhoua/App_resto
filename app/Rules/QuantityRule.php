<?php

namespace App\Rules;

use App\Models\Recette;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class QuantityRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $index = explode('.', $attribute)[1];

        $recette_id = request()->input("recettes.{$index}");

        $quantity = request()->input("quantity.{$index}");

        $recette = Recette::where('id', $recette_id)->first();

        if(is_numeric($quantity)){
            
            if ($quantity < 0 ) {
                $fail('la quantité '.$recette->name.' saisie est invalide, s\'il vous plait entrez une quantité supérieur à 0!');
            }
        }
        else
        {
            $fail('la quantité '.$recette->name.' saisie est invalide, s\'il vous plait entrez une quantité valide!');
        }
    }
}
