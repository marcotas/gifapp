<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    public function show(Request $request)
    {
        $values = $this->validate($request, [
            'url' => 'required|url',
        ]);

        $shortUrl = ShortUrl::query()->firstOrCreate([
            'long' => $values['url'],
        ]);

        return [
            'short_url' => $shortUrl->short,
        ];
    }

    public function redirect($code)
    {
        $shortUrl = ShortUrl::findByCode($code);

        return redirect($shortUrl->long);
    }
}
