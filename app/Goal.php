<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function assistant()
    {
        return $this->belongsTo(Player::class, 'assist_id');
    }

    public function match()
    {
        return $this->belongsTo(Match::class);
    }
}
