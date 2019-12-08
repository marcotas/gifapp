<?php

use App\Facades\Shortener;
use App\Models\User;

function user(): ? User
{
    return auth()->user();
}

function biencrypt($integer)
{
    return Shortener::encode($integer);
}

function bidecrypt(string $code)
{
    return Shortener::decode($code);
}
