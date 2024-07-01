<?php

namespace Database\Seeders;

use App\Models\Medecin;
use App\Models\Specialites;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            "name"=> "Soufiane",
            "email"=> "soufiane@gmail.com",
            "password"=> Hash::make("soufiane"),
            "role"=> "admin",
                
        ]);
        User::create([
            "name"=> "Mohammed",
            "email"=> "Mohammed@gmail.com",
            "password"=> Hash::make("Mohammed"),
            "role"=> "medecin",
                
        ]);
        User::create([
            "name"=> "Alaoui",
            "email"=> "Alaoui@gmail.com",
            "password"=> Hash::make("Alaoui12"),
            "role"=> "medecin",
                
        ]);
        Specialites::create([
            "nom"=> "Cardio",      
        ]);
        Specialites::create([
            "nom"=> "Neurologist",      
        ]);
        Medecin::create([
            "specialites_id"=> "1",      
            "user_id"=> "2",      
        ]);
        Medecin::create([
            "specialites_id"=> "2",      
            "user_id"=> "3",      
        ]);

    }
}
