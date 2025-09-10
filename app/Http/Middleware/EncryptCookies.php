<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    // Add any cookies you don't want to encrypt
    protected $except = [
        //
    ];
}
