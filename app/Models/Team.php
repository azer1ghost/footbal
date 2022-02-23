<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static orderBy(string $string)
 * @method static create(string[] $array)
 * @method static get()
 */
class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'points', 'played', 'won', 'lost', 'drawn', 'gf', 'ga', 'gd'];

    public $timestamps = false;

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

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
            'played' => $this->playedGames()->count(),
            'points' => 0,
            'won'    => 0,
            'lost'   => 0,
            'drawn'  => 0,
            'gf'     => 0,
            'ga'     => 0,
            'gd'     => 0
        ];

        foreach ($this->playedGames as $game){

            $rivalGoals = $game->teams()->where('id', '!=', $this->id)->first()->gameResult($game);

            $thisGoals = $this->gameResult($game);

            if ($thisGoals > $rivalGoals){
                $stats['won'] ++;
                $stats['points'] += 3;
            }

            if($thisGoals == $rivalGoals){
                $stats['drawn'] ++;
                $stats['points'] += 1;
            }

            if($thisGoals < $rivalGoals) {
                $stats['lost'] ++;
            }

            $stats['gf'] += $thisGoals;
            $stats['ga'] += $rivalGoals;
            $stats['gd'] += ($thisGoals - $rivalGoals);
        }

        $this->update($stats);
    }
}
