<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'position',
        'height',
        'weight',
        'age',
        'photo',
        'squad_id',
        'club_id'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function assists()
    {
        return $this->hasMany(Goal::class, 'assist_id');
    }

    public function squads()
    {
        $this->hasMany(Squad::class);
    }


}
