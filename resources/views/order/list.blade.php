@extends('layouts/contentLayoutMaster')

@section('title', 'Orders')

@section('meta-block')
    <meta http-equiv="refresh" content="300">
@endsection

@section('content')
    <div class="row match-height">

        <!-- Statistics Card -->
        <div class="col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">Statistics</h4>
                </div>
                <div class="card-body statistics-body">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <i data-feather="trending-up" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $orderLists->count() }}</h4>
                                    <p class="card-text font-small-3 mb-0">Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-info me-2">
                                    <div class="avatar-content">
                                        <i data-feather="user" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $orderLists->where('status', 1)->count() }}</h4>
                                    <p class="card-text font-small-3 mb-0">Active Orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-danger me-2">
                                    <div class="avatar-content">
                                        <i data-feather="box" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">
                                        {{ count($symbols) }}
                                    </h4>
                                    <p class="card-text font-small-3 mb-0">Unique Symbols</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-success me-2">
                                    <div class="avatar-content">
                                        <i data-feather="dollar-sign" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">
                                        ${{ round(array_sum($orderLists->map(function ($orderList) {return $orderList->diffDollar;})->toArray()),2) }}
                                    </h4>
                                    <p class="card-text font-small-3 mb-0">Revenue</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Statistics Card -->
    </div>
    <div class="row">

        <!-- Statistics Card -->
        <div class="col-12">
            <div class="card card-progress">
                <div class="card-body" style="padding-bottom: 0">
                    <div class="row mb-2">
                        @foreach ($symbols as $symbol)
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                <div class="d-flex flex-row">
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ str_replace('USDT', '', $symbol) }}</h4>
                                        <p class="card-text font-small-3 mb-0" id="{{ strtolower($symbol) }}-price">Price
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12 mb-2 mb-xl-0">
                            <div class="progress progress-bar-primary" style="height: 2px">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="5"
                                    aria-valuemax="100" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Statistics Card -->
    </div>
    <div class="card">
        <div class="card-header">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="active"
                    @if ((bool) request()->query('active') === true) checked="" @endif>
                <label class="form-check-label" for="active">Show active only</label>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Symbol</th>
                            <th>Buy Price</th>
                            <th>Sell Price</th>
                            <th>Qty</th>
                            <th>Buy $</th>
                            <th>Sell $</th>
                            <th>Strategy</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orderLists->count() > 0)
                            @foreach ($orderLists as $orderList)
                                <tr>
                                    <td>
                                        {{ $orderList->symbol }}
                                    </td>
                                    <td>{{ round($orderList->buy_price, 5) }}</td>
                                    <td>
                                        {{ $orderList->sell_price ? round($orderList->sell_price, 5) : '-' }}&nbsp;
                                        @if ($orderList->sell_price)
                                            <span
                                                class="@if ($orderList->diff > 0) text-success @else text-danger @endif">
                                                <small>{{ round($orderList->diff, 5) }}</small>
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ round($orderList->quantity, 12) }}</td>
                                    <td>
                                        {{ round($orderList->buyAggregate, 3) }}
                                    </td>
                                    <td>
                                        {{ $orderList->sell_price ? round($orderList->sellAggregate, 3) : '-' }} &nbsp;
                                        @if ($orderList->sell_price)
                                            <span
                                                class="@if ($orderList->diff > 0) text-success @else text-danger @endif">
                                                <small>{{ round($orderList->diffDollar, 3) }}</small>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $orderList->strategy }}
                                    </td>
                                    <td>
                                        @if ($orderList->status === '1')
                                            <a
                                                href="{{ route('order.close.get', ['symbol' => $orderList->symbol, 'userEmail' => Auth::user()->email]) }}">
                                                <span class="btn btn-sm btn-relief-warning">
                                                    Panic sell
                                                </span>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">No data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Kick start -->
@endsection

@section('self-script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var symbols = JSON.parse('{!! json_encode($symbols) !!}')
        symbols.forEach(symbol => {
            fetchPrice(symbol);
        });

        setInterval(() => {
            var progressBar = document.querySelector(".progress-bar"),
                maxProgressBar = 100,
                progress = parseInt(progressBar.style.width.replace("%", ""))

            progressBar.style.width = (progress != 100 ? progress += 10 : progress = 0) + "%"
        }, 1000);

        setInterval(() => {
            symbols.forEach(symbol => {
                fetchPrice(symbol);
            });
        }, 11000);

        function fetchPrice(symbol) {
            axios({
                method: 'get',
                url: 'https://api.binance.com/api/v3/ticker/price?symbol=' + symbol
            }).then(function(response) {
                document.querySelector("#" + symbol.toLowerCase() + "-price").textContent = Math.round(response.data
                    .price * 1000) / 1000;
            }).catch(error => {
                console.log(error)
            });
        }
    </script>
@endsection
