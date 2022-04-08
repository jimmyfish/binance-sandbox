<?php

namespace App\Http\Controllers\Watchlists;

use App\Models\Watchlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewAction extends Controller
{
    public function __invoke()
    {
        $watchlists = Watchlist::all();
        
        return view('watchlists.view', [
            'watchlists' => $watchlists,
        ]);
    }
}
