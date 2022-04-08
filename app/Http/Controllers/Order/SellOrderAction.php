<?php

namespace App\Http\Controllers\Order;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Transact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellOrderAction extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'userEmail' => 'required|exists:users,email',
            'symbol' => 'required|string|max:10',
        ]);

        $symbol = $request->get('symbol');
        $user = User::where('email', $request->get('userEmail'))->first();

        $transaction = Transact::select(['id', 'quantity'])
            ->where([
                'symbol' => $symbol,
                'status' => 1,
                'user_id' => $user->id
            ])->first();

        if (!$transaction) return response()->json('order not found', 400);

        $client = new Client([
            'headers' => [
                'content-type' => 'application/json',
                'accept' => 'application/json'
            ]
        ]);

        $response = $client->get("https://api.binance.com/api/v3/ticker/price?symbol=$symbol");
        $response = json_decode($response->getBody()->getContents());
        $price = $response->price;

        // Close order
        $closeTransaction = Transact::find($transaction->id)->update([
            'sell_price' => $price,
            'status' => 2
        ]);

        $priceAggregate = $price * $transaction->quantity;
        $newBalance = $user->balance + $priceAggregate;
        $updateUserBalance = User::find($user->id)->update(['balance' => $newBalance]);

        return response()->json('sell order complete');
    }
}
