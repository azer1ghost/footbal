<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'PTS', 'P', 'W', 'L', 'D', 'GD'];

    public $timestamps = false;

    public function games(): BelongsToMany
    {
        return $this
                    ->belongsToMany(Game::class)
                    ->as('data')
                    ->withPivot('is_host', 'goals', 'played');
    }

    public function playedGames(): BelongsToMany
    {
        return $this->games()->wherePivot('played', true);
    }

    public function gameResult(Game $game)
    {
        return $this->playedGames()->find($game)->data->getAttribute('goals');
    }

    public function calculateStats(){

        $stats = [
            'PTS' => $this->playedGames()->count(),
            'P'   => 0,
            'W'   => 0,
            'L'   => 0,
            'D'   => 0,
            'GD'  => 0
        ];

        foreach ($this->playedGames as $game){

            $rivalGoals = $game->teams()->where('id', '!=', $this->id)->first()->gameResult($game);

            $thisGoals = $this->gameResult($game);

            if ($thisGoals > $rivalGoals){
                $stats['W'] ++;
                $stats['P'] += 3;
            }

            if($thisGoals == $rivalGoals){
                $stats['D'] ++;
                $stats['P'] += 1;
            }

            if($thisGoals < $rivalGoals) {
                $stats['L'] ++;
            }

            $stats['GD'] += ($thisGoals - $rivalGoals);
        }

        $this->update($stats);
    }
}
