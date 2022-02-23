<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Team;
use App\Models\Week;
use App\Services\Matchmaking;
use Illuminate\Support\Collection;

class TeamController extends Controller
{
    public function index()
    {
//        $this->reGenerate();
        return view('index');
    }

    public function teams()
    {
        return Team::get();
    }

    public function groups()
    {
        return Group::orderBy('name')->get();
    }

    public function week(Week $week)
    {
        $week->load('games.teams');

        return $week;
    }

    public function playWeek(Week $week)
    {
        $week->games->each(function ($game){
            $game->simulate();
        });
    }

    public function reGenerate()
    {
        $this->makeGroups();

        for ($i = 0; $i < 6; $i++){
            Week::create();
        }

        $this->groups()->each(fn ($group) =>
            $this->saveMatchmaking(
                Matchmaking::generate($group->teams)
            )
        );
    }

    public function makeGroups()
    {
        $this->teams()->chunk(4)->each(function ($teams){
            $group = Group::create();
            $teams->each(fn ($team) =>
                $team->group()->associate($group)->save()
            );
        });
    }

    public function saveMatchmaking(Collection $weeks)
    {
        $i = 1;
        $weeks->map(function ($gamesInWeek) use (&$i) {
            $week = Week::find($i);
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
            $i++;
        });
    }
}
