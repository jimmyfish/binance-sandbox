# Binance Sandbox
## Codename : BNAN-A

This wasn't afiliated with any service or legit trade with binance, nor presented by binance itself.   

This sandbox serve as local sandbox, used for testing your trading strategy.   

Key Feature :
- Buy
- Sell
- Balance management
- Log
- Configuration of kline's timestamp

Even it's called **Binance sandbox** , the data on this sandbox isn't related to your binance account (No API Token needed). This app only get klines and current price data from binance.

How to use
---

1. Configure your .env
2. Install dependency via `composer install`
3. Import SQL in `database/migrations` directory
4. Run like your ordinary laravel project
5. Enjoy your sandbox

Optional
---
configure view, so you can view the page inside your browser through GUI

1. install assets `npm install`
2. Initialize production assets `npm mix --production`