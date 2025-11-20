<?php

namespace App\Constants;

class ApiMessages
{
    // Error Messages
    public const ERROR_INSUFFICIENT_BALANCE = 'insufficient balance';
    public const ERROR_ORDER_REJECTION = 'rejection';
    public const ERROR_ORDER_NOT_FOUND = 'order not found';
    public const ERROR_FAILED_TO_CREATE_ORDER = 'Failed to create order';
    public const ERROR_FAILED_TO_CLOSE_ORDER = 'Failed to close order';
    public const ERROR_FAILED_TO_FETCH_MARKET_PRICE = 'Failed to fetch market price';
    public const ERROR_INVALID_MARKET_API_RESPONSE = 'Invalid response from market API';
    public const ERROR_FAILED_TO_CONNECT_MARKET_API = 'Failed to connect to market API';
    public const ERROR_FETCHING_MARKET_PRICE = 'An error occurred while fetching market price';

    // Success Messages
    public const SUCCESS_SELL_ORDER_COMPLETE = 'sell order complete';
    public const SUCCESS_LOG_CREATED = 'Log created successfully';
}
