# Quick Fixes - Critical Issues

## 🔴 Must Fix Immediately

### 1. Mass Assignment Vulnerability
**Files:** `app/Models/User.php`, `app/Models/Transact.php`, `app/Models/Log.php`, `app/Models/TradeStrategy.php`

**Change:**
```php
// FROM:
protected $guarded = [];

// TO:
protected $fillable = [
    // List all fillable fields explicitly
];
```

### 2. Add API Authentication
**File:** `routes/api.php`

**Change:**
```php
// Wrap order and log routes in auth middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('order', CreateOrderAction::class)->name('order.create');
    Route::delete('order', SellOrderAction::class)->name('order.close');
    Route::post('log', LoggerAction::class)->name('log.write');
});
```

### 3. Fix Deprecated Middleware Property
**File:** `app/Http/Kernel.php`

**Change:**
```php
// FROM:
protected $routeMiddleware = [

// TO:
protected $middlewareAliases = [
```

### 4. Remove Deprecated Namespace
**File:** `app/Providers/RouteServiceProvider.php`

**Change:**
```php
// Remove ->namespace($this->namespace) from both route groups
Route::prefix('api')
    ->middleware('api')
    ->group(base_path('routes/api.php'));

Route::middleware('web')
    ->group(base_path('routes/web.php'));
```

### 5. Use Eloquent create() Instead of insert()
**File:** `app/Http/Controllers/Order/CreateOrderAction.php`

**Change:**
```php
// FROM:
$transact = Transact::insert($payload);

// TO:
$transact = Transact::create($payload);
```

### 6. Add Database Transactions
**Files:** `app/Http/Controllers/Order/CreateOrderAction.php`, `app/Http/Controllers/Order/SellOrderAction.php`

**Change:**
```php
// Wrap database operations in transactions
use Illuminate\Support\Facades\DB;

DB::transaction(function () use ($payload, $user, $newBalance) {
    $transact = Transact::create($payload);
    $user->update(['balance' => $newBalance]);
});
```

### 7. Add Return Statement
**File:** `app/Http/Controllers/LoggerAction.php`

**Change:**
```php
public function __invoke(Request $request)
{
    $log = Log::create([...]);
    return response()->json(['message' => 'Log created'], 201);
}
```

## ⚠️ High Priority

### 8. Add Error Handling for External APIs
**Files:** `app/Http/Controllers/Order/CreateOrderAction.php`, `app/Http/Controllers/Order/SellOrderAction.php`

**Add try-catch blocks around API calls**

### 9. Fix Inefficient Queries
**Files:** `app/Http/Controllers/Order/CreateOrderAction.php`, `app/Http/Controllers/Order/SellOrderAction.php`

**Change:**
```php
// FROM:
User::find($user->id)->update(['balance' => $newBalance]);

// TO:
$user->update(['balance' => $newBalance]);
```

### 10. Add Mass Assignment to Watchlist Model
**File:** `app/Models/Watchlist.php`

**Add:**
```php
protected $fillable = [
    // Add appropriate fields
];
```
