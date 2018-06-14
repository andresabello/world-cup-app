<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = [
        'name', 'starts_at', 'ends_at', 'number', 'tournament_id'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
