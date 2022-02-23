<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static orderBy(string $string)
 * @method static create()
 */
class Group extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    protected static function booted()
    {
        static::creating(function ($group) {
            $lastGroupName = self::latest('id')->first()?->getAttribute('name');
            $group->setAttribute('name', is_null($lastGroupName) ? 'A' :++$lastGroupName);
        });
    }
}
