<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OAuthProvider extends Model
{
    protected $table = 'oauth_providers';
    protected $fillable = [
        'active',
        'name',
        'oauth_id',
        'access_token',
        'refresh_token',
        'expires_in',
        'user_id'
    ];
    /**
     * The users that belong to the role.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
