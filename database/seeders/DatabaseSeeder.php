<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\Team::create([
            'name' => 'Arsenal'
         ]);

        \App\Models\Team::create([
            'name' => 'Chelsea'
        ]);

        \App\Models\Team::create([
            'name' => 'Tottenham'
        ]);

        \App\Models\Team::create([
            'name' => 'Liverpool'
        ]);
    }
}
