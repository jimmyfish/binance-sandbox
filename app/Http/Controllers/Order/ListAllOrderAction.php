<?php

namespace App\Http\Controllers\Order;

use App\Models\User;
use App\Models\Transact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ListAllOrderAction extends Controller
{
    public function __invoke(Request $request)
    {
        /**@var $user User */
        $user = Auth::user();
        
        $orderLists = $user->orders()->orderBy('status', 'ASC')->orderBy('created_at', 'DESC');

        if ($request->has('active') && $request->get('active')) $orderLists = $orderLists->where('status', 1);

        if ($request->has('symbol')) $orderLists = $orderLists->where('symbol', $request->get('symbol'));

        $orderLists = $orderLists->get();

        $orderLists->each(function ($orderList) {
            $orderList->diff = $orderList->sell_price - $orderList->buy_price;
            $orderList->buyAggregate = $orderList->buy_price * $orderList->quantity;
            $orderList->sellAggregate = $orderList->sell_price * $orderList->quantity;
            $equity = $orderList->sellAggregate - $orderList->buyAggregate;
            $orderList->diffDollar = $orderList->status === '2' ? $equity: 0;
        });

        $symbols = array_unique($orderLists->map(function ($orderList) {return $orderList->symbol;})->toArray());

        return view('order.list', ['orderLists' => $orderLists, 'symbols' => $symbols]);
    }
}
