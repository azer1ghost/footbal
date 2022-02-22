<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Week;
use App\Services\Matchmaking;
use Illuminate\Support\Collection;

class TeamController extends Controller
{
    public function index()
    {
//        $this->reGenerate();

//        return Matchmaking::generate(Team::get());

        return view('index');
    }

    public function teams()
    {
        return Team::get();
    }

    public function week($id)
    {
        return Week::with('games.teams')->find($id);
    }

    public function playWeek($id)
    {
        $this->week($id)->games->each(function ($game){
            $game->simulate();
        });
    }

    public function reGenerate()
    {
        $this->saveMatchmaking(
            Matchmaking::generate(Team::get())
        );
    }

    public function saveMatchmaking(Collection $weeks)
    {
        $weeks->map(function ($gamesInWeek) {
            $week = Week::create();
            foreach ($gamesInWeek as $game):
                $week
                    ->games()
                    ->create()
                    ->teams()
                    ->attach([
                        $game[0]->id => ['is_host' => true],
                        $game[1]->id => ['is_host' => false]
                    ]);
            endforeach;
        });
    }
}
