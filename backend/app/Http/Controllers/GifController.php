<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class GifController extends Controller
{
    public function index(Request $request)
    {
        return File::all();
    }

    public function store(Request $request)
    {
        // dd('store', $request->all());
    }
}
