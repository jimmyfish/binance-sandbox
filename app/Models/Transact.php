<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transact extends Model
{
    use HasFactory;

    protected $table = 'transact';

    protected $fillable = [
        'symbol',
        'buy_price',
        'sell_price',
        'quantity',
        'user_id',
        'status',
        'strategy',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
