<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteGifController extends Controller
{
    public function toggle(Request $request)
    {
        $values = $this->validate($request, [
            'tenor_id' => 'required|numeric',
        ]);
        $favoriteGifs = user()->favorite_gifs;
        if (!$favoriteGifs->contains((int) $values['tenor_id'])) {
            $favoriteGifs->push((int) $values['tenor_id']);
        } else {
            $favoriteGifs = $favoriteGifs->filter(function ($id) use ($values) {
                return (int) $id !== (int) $values['tenor_id'];
            })->values();
        }

        user()->update(['favorite_gifs' => $favoriteGifs]);

        return ['favorite_gifs' => $favoriteGifs];
    }
}
