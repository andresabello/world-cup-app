<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'flag',
        'group_id',
        'main_color',
        'second_color',
        'third_color'
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_teams');
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(Match::class, 'home_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(Match::class, 'away_id');
    }

    public function wins()
    {
        return $this->hasMany(Match::class, 'winner_id');
    }

    public function squad()
    {
        return $this->hasMany(Squad::class);
    }

}
