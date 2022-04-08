<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\TradeStrategy;
use Illuminate\Http\Request;

class ShowTradeStrategiesAction extends Controller
{
    public function __invoke(Request $request)
    {
        $tradeStategies = TradeStrategy::withTrashed()->get();

        return view('strategy.trade', ['tradeStrategies' => $tradeStategies]);
    }
}
