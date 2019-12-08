<?php

namespace App\Support;

class Shortener
{
    public $alphabet = 'KVXOQnDM1lgyaHpEwJPsi4bo506BcLGuFTxmdRfhtkNvqZjY3ArezSIWU97C82';

    public function __construct()
    {
        $this->alphabet = str_split($this->alphabet);
    }

    public function encode($integer)
    {
        if ($integer == 0) {
            return $this->alphabet[0];
        }
        $result = [];
        $base   = count($this->alphabet);
        while ($integer > 0) {
            $result[] = $this->alphabet[($integer % $base)];
            $integer  = floor($integer / $base);
        }
        $result = array_reverse($result);

        return join('', $result);
    }

    public function decode(string $code)
    {
        $integer = 0;
        $base    = count($this->alphabet);
        $code    = str_split($code);
        foreach ($code as $char) {
            $pos     = array_search($char, $this->alphabet);
            $integer = $integer * $base + $pos;
        }

        return $integer;
    }
}
