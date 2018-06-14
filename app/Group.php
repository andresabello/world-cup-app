<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'team_id',
        'name'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function teams ()
    {
        return $this->hasMany(Team::class);
    }

    public function matches ()
    {
        return $this->hasMany(Match::class);
    }
}
