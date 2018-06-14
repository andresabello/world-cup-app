<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Squad extends Model
{
    protected $fillable = [
        'number', 'position', 'team_id'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
