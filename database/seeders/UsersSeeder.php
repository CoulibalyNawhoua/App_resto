<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'first_name' => "coulibaly",
            'last_name' =>  'nawhoua',
            'email' => 'coulibaly.nawhoua@softexpertise.com',
            'password'  => Hash::make('coulibaly$'),
            'email_verified_at' => now(),
        ]);
    }
}
