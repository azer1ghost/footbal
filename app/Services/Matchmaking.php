<?php

namespace App\Services;

use Illuminate\Support\Collection;

class Matchmaking
{
    public static function generate(Collection|array $teams): Collection
    {
        $teams = $teams->shuffle();

        $combinations = []; $revenge = [];

        $countTeams = count($teams);

        for ($i = 0; $i < $countTeams; $i++) {
            for ($k = $i + 1; $k < $countTeams; $k++) {
                $combinations[] = [$teams[$i], $teams[$k]];
                $revenge[] = [$teams[$k], $teams[$i]];
            }
        }

        $combinations = array_merge($combinations, $revenge);

        $weeks = [];

        $countCombinations = count($combinations);

        for ($i = 0; $i < $countCombinations / 2; $i++) {

            $weeks[] = [$combinations[$i], $combinations[$countCombinations - 1 - $i]];

        }

        return collect($weeks);
    }
}
