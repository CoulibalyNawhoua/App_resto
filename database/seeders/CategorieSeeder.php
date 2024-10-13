<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Categorie::create([
            'nom_categorie' => "Produit semi finis",
            'code_categorie' => 'CAT-002'
        ]);

        Categorie::create([
            'nom_categorie' => "Matière première",
            'code_categorie' => 'CAT-001'
        ]);

        Categorie::create([
            'nom_categorie' => "Produit finis",
            'code_categorie' => 'CAT-003'
        ]);
    }
}
