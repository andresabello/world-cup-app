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

    public function group()
    {
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

    public function squads()
    {
        return $this->hasMany(Squad::class);
    }

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class);
    }

    public function scopeTranslatedName($query, $name)
    {
        $translated = $this->translated();
        if (key_exists($name, $translated)) {
            return $query->where('name', $translated[$name])->first();
        }
    }


    protected function translated()
    {
        return [
            'Russia' => 'Rusia',
            'Egypt' => 'Egipto',
            'Uruguay' => 'Uruguay',
            'Saudi Arabia' => 'Arabia Saudita',
            'Portugal' => 'Portugal',
            'Morocco' => 'Marruecos',
            'Iran' => 'Iran',
            'Iran IR' => 'Iran',
            'Iran Ir' => 'Iran',
            'Spain' => 'Espana',
            'France' => 'Francia',
            'Australia' => 'Australia',
            'Peru' => 'Peru',
            'Denmark' => 'Dinamarca',
            'Argentina' => 'Argentina',
            'Iceland' => 'Islandia',
            'Croatia' => 'Croacia',
            'Nigeria' => 'Nigeria',
            'Costa Rica' => 'Costa Rica',
            'Serbia' => 'Serbia',
            'Brazil' => 'Brasil',
            'Switzerland' => 'Suiza',
            'Germany' => 'Alemania',
            'Mexico' => 'Mexico',
            'Sweden' => 'Suecia',
            'Korea Republic' => 'Corea Del Sur',
            'South Korea' => 'Corea Del Sur',
            'Belgium' => 'Belgica',
            'Panama' => 'Panama',
            'Tunisia' => 'Tunez',
            'England' => 'Inglaterra',
            'Colombia' => 'Colombia',
            'Japan' => 'Japon',
            'Senegal' => 'Senegal',
            'Poland' => 'Polonia',
        ];
    }

}
