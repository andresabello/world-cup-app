<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    protected $fillable = [
        'number', 'position', 'team_id', 'player_id'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

}
