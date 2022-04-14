<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Transact;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CreateOrderAction extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'userEmail' => 'required|string|exists:users,email',
            'symbol' => 'required|string|max:10',
            'quantity' => 'required|numeric'
        ]);

        $client = new Client([
            'headers' => [
                'content-type' => 'application/json',
                'accept' => 'application/json'
            ]
        ]);

        $symbol = $request->get('symbol');

        $response = $client->get("https://api.binance.com/api/v3/ticker/price?symbol=$symbol");
        $response = json_decode($response->getBody()->getContents());
        $price = $response->price;

        $user = User::where('email', $request->get('userEmail'))->first();

        $priceAggregate = $price * $request->get('quantity');
        $newBalance = $user->balance - $priceAggregate;

        if ($newBalance < 0) return response()->json('insufficient balance', 400);

        $payload = [
            'symbol' => $symbol,
            'buy_price' => $price,
            'user_id' => $user->id,
            'quantity' => $request->get('quantity'),
            'strategy' => $request->get('strategy')
        ];

        $duplicate = Transact::where([
            'symbol' => $symbol,
            'status' => 1,
            'user_id' => $user->id
        ])->get();

        if ($duplicate->count() > 0) {
            return response()->json('rejection', 400);
        }

        $transact = Transact::insert($payload);
        $updateUserBalance = User::find($user->id)->update(['balance' => $newBalance]);

        return response()->json($transact);
    }
}
