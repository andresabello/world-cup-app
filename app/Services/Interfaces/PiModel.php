<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 3/18/18
 * Time: 5:03 PM
 */

namespace App\Services\Interfaces;


interface PiModel
{
    public function find(string $field, string $value);
}