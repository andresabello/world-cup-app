<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'source',
        'excerpt',
        'image',
        'title',
        'description',
        'published_at',
        'added_on',
        'source_name'
    ];

    protected $dates = [
        'added_on', 'published_at'
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'news_teams');
    }
}
