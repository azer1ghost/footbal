<?php

namespace Database\Seeders;

use App\Models\Team;
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
        $teams = ['Arsenal', 'Chelsea', 'Tottenham', 'Liverpool', 'Manchester City', 'Leicester', 'Manchester United', 'Everton'];

        foreach ($teams as $team){
            Team::create([
                'name' => $team
            ]);
        }
    }
}
