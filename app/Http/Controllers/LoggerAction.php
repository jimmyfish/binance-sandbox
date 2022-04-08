<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LoggerAction extends Controller
{
    public function __invoke(Request $request)
    {
        Log::create([
            'symbol' => $request->get('symbol'),
            'data' => $request->get('data'),
            'action' => $request->get('action')
        ]);
    }
}
