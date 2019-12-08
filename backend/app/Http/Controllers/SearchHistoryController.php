<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchHistoryController extends Controller
{
    public function index()
    {
        return JsonResource::collection(
            user()->searchHistories()->latest('updated_at')->paginate()
        );
    }

    public function store(Request $request)
    {
        $values = $this->validate($request, [
            'text' => 'required|max:255',
        ]);

        $searchHistory = user()->searchHistories()->firstOrCreate($values);
        $searchHistory->hit();

        return $searchHistory;
    }
}
