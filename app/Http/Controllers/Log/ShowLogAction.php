<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class ShowLogAction extends Controller
{
    public function __invoke(Request $request)
    {
        $logs = Log::where('symbol', 'like', "%" . $request->get('symbol') . "%")
            ->orderBy('created_at', 'DESC')
            ->paginate(100);
            
        $symbols = array_unique(Log::select('symbol')->pluck('symbol')->toArray());

        $logs->each(function ($log) {
            $log->data = json_decode($log->data);
        });

        return view('log.list', ['logs' => $logs, 'symbols' => $symbols]);
    }
}
