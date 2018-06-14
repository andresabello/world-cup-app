<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'city',
        'county',
        'image',
        'capacity'
    ];

    public function matches()
    {
        return $this->hasMany(Match::class);
    }
}
