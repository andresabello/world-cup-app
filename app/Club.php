<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'name',
        'followers',
        'president',
        'rank',
        'stadium',
        'uniform'
    ];

    public function player()
    {
        return $this->hasMany(Player::class, 'club_id');
    }
}
