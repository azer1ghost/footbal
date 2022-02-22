<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $timestamps = false;

    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class);
    }

    public function teams(): BelongsToMany
    {
        return $this
                    ->belongsToMany(Team::class)
                    ->as('data')
                    ->withPivot('is_host', 'goals', 'played');
    }

    public function simulate()
    {
        $this->teams->each(function ($team){
            $team->games()->updateExistingPivot($this->id, [
                'goals'  => rand(0, rand(1, rand(2, 5))),
                'played' => true,
            ]);
        });

        $this->teams->each(function ($team){
            $team->calculateStats();
        });
    }
}
