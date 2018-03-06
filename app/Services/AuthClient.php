<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 3/3/18
 * Time: 8:41 AM
 */

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;

class AuthClient
{
    /**
     * @param string $type
     * @param string $name
     * @return mixed
     */
    public function get(string $type, string $name)
    {
        $client = Client::where('revoked', 0)->where('name', $name);

        switch ($type) {
            case 'password' :
                $client->where('personal_access_client', 0)
                    ->where('password_client', 1);
                break;
            case 'personal' :
                $client->where('personal_access_client', 1)
                    ->where('password_client', 0);
                break;
            default :
                $client->where('personal_access_client', 0)
                    ->where('password_client', 0);
                break;
        }

        return $client->first();
    }
}