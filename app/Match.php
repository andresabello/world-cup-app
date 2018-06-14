<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'number',
        'play_at',
        'knockout',
        'home_id',
        'away_id',
        'venue_id',
        'group_id',
        'winner_id',
        'score',
        'score_et',
        'score_pt'
    ];

    protected $dates = [
        'play_at'
    ];

    public function home()
    {
        return $this->belongsTo(Team::class, 'home_id');
    }

    public function away()
    {
        return $this->belongsTo(Team::class, 'away_id');
    }

    public function winner()
    {
        return $this->belongsTo(Team::class, 'winner_id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

}
