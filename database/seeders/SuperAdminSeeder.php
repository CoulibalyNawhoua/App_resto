<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => "Djamala",
            'last_name' =>  'Kouakou xavier',
            'email' => 'xavier.djamala@softexpertise.com',
            'password'  => Hash::make('softexpertise@2022'),
            'email_verified_at' => now(),
        ]);

        $role = Role::findByName('super-admin');

        $user->assignRole([$role->id]);
    }
}
