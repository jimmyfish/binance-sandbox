<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Transact;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        try {
            $response = $client->get("https://api.binance.com/api/v3/ticker/price?symbol=$symbol");
            
            if ($response->getStatusCode() !== 200) {
                return response()->json(['error' => 'Failed to fetch market price'], 500);
            }
            
            $responseData = json_decode($response->getBody()->getContents());
            
            if (!isset($responseData->price)) {
                return response()->json(['error' => 'Invalid response from market API'], 500);
            }
            
            $price = $responseData->price;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json(['error' => 'Failed to connect to market API'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching market price'], 500);
        }

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

        try {
            DB::beginTransaction();

            $transact = Transact::create($payload);
            $user->update(['balance' => $newBalance]);

            DB::commit();

            return response()->json($transact);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create order'], 500);
        }
    }
}
