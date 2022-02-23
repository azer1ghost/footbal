<?php

namespace App\Services;

use Illuminate\Support\Collection;

class Matchmaking
{
    public static function generate(Collection|array $teams): Collection
    {
        $teams = collect($teams)->shuffle();

        $matches = self::matchesMaker($teams);

        return self::weeklyMatchPlanner($matches);
    }

    public static function matchesMaker(Collection|array $teams): array
    {
        $firstMatch = []; $revengeMatch = [];

        $countTeams = count($teams);

        for ($i = 0; $i < $countTeams; $i++) {
            for ($k = $i + 1; $k < $countTeams; $k++) {
                $firstMatch[] = [$teams[$i], $teams[$k]];
                $revengeMatch[] = [$teams[$k], $teams[$i]];
            }
        }

        return array_merge($firstMatch, $revengeMatch);
    }

    public static function weeklyMatchPlanner(array $combinations): Collection
    {
        $weeks = [];
        $countCombinations = count($combinations);
        for ($i = 0; $i < $countCombinations / 2; $i++) {
            $weeks[] = [$combinations[$i], $combinations[$countCombinations - 1 - $i]];
        }
        return collect($weeks);
    }
}
