<?php

namespace App\Http\Controllers\Order;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Transact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        try {
            DB::beginTransaction();

            // Close order
            $transaction->update([
                'sell_price' => $price,
                'status' => 2
            ]);

            $priceAggregate = $price * $transaction->quantity;
            $newBalance = $user->balance + $priceAggregate;
            $user->update(['balance' => $newBalance]);

            DB::commit();

            return response()->json('sell order complete');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to close order'], 500);
        }
    }
}
