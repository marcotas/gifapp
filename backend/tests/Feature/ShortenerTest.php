<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ShortenerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_transform_an_integer_into_a_string_code()
    {
        $limit = 999_999_999_999_999;

        $codeLimit = biencrypt($limit);
        $this->assertEquals($limit, bidecrypt($codeLimit));

        collect()->times(10_000_000, function ($index) use ($limit) {
            $number = rand(10_000_000, $limit);
            $code = biencrypt($number);
            $this->assertEquals($number, bidecrypt($code));
            $code = biencrypt($index);
            $this->assertEquals($index, bidecrypt($code));
        });
    }
}
