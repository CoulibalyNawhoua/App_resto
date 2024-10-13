<?php

namespace Database\Seeders;

use App\Models\Entite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepotPrincipalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Entite::create([
            'name' => "DEPOT PRINCIPAL",
            'use_depot_principal' =>  1,
        ]);
    }
}
