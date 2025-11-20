<?php

namespace App\Http\Controllers;

use App\Constants\ApiMessages;
use App\Models\Log;
use Illuminate\Http\Request;

class LoggerAction extends Controller
{
    public function __invoke(Request $request)
    {
        $log = Log::create([
            'symbol' => $request->get('symbol'),
            'data' => $request->get('data'),
            'action' => $request->get('action')
        ]);

        return response()->json([
            'message' => ApiMessages::SUCCESS_LOG_CREATED,
            'id' => $log->id
        ], 201);
    }
}
