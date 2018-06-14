<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'name',
        'prize',
        'season_id',
        'league_id'
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function League()
    {
        return $this->belongsTo(League::class);
    }

}
