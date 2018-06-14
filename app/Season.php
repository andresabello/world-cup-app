<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'name', 'prize'
    ];

    public function competition()
    {
        return $this->hasOne(Tournament::class);
    }

}
