<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string encode($integer)
 * @method static int decode(string $code)
 */
class Shortener extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Support\Shortener::class;
    }
}
