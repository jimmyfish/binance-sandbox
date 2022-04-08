@extends('layouts/contentLayoutMaster')

@section('title', 'Logs')

@section('meta-block')
    <meta http-equiv="refresh" content="300">
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="form-group">
                <label for="symbol">Filter by symbol : </label>
                <select name="symbol" id="symbol" class="form-select">
                    @foreach ($symbols as $symbol)
                        <option value="{{ $symbol }}">{{ $symbol }}</option>
                    @endforeach
                </select>
            </div>
            <p><small><strong>PS.</strong> left data is previous data, <strong>black-tint</strong> is variables which monitored by trade script</small></p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Symbol</th>
                            <th>Close</th>
                            <th>upperBB</th>
                            <th>lowerBB</th>
                            <th>macd</th>
                            <th>bbr</th>
                            <th>Buy ?</th>
                            <th>Sell ?</th>
                            <th>Action taken</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @if (count($logs->items()) > 0)
                            @foreach ($logs->items() as $log)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>
                                        {{ $log->symbol }}
                                    </td>
                                    <td>
                                        @foreach (collect($log->data->Close)->values() as $key => $data)
                                            @if ($key == 1)
                                                <strong>{{ $data }}</strong>
                                            @else
                                                <span class="text-warning"><small>{{ $data }}</small></span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (collect($log->data->upperBB)->values() as $key => $data)
                                            @if ($key == 1)
                                                <strong>{{ round($data, 2) }}</strong>
                                            @else
                                                <span class="text-warning"><small>{{ round($data, 2) }}</small></span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (collect($log->data->lowerBB)->values() as $key => $data)
                                            @if ($key == 1)
                                                <strong>{{ round($data, 2) }}</strong>
                                            @else
                                                <span class="text-warning"><small>{{ round($data, 2) }}</small></span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (collect($log->data->macd)->values() as $key => $data)
                                            @if ($key == 1)
                                                <strong>{{ round($data, 2) }}</strong>
                                            @else
                                                <span class="text-warning"><small>{{ round($data, 2) }}</small></span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (collect($log->data->bbr)->values() as $key => $data)
                                            @if ($key == 1)
                                                <strong>{{ round($data, 2) }}</strong>
                                            @else
                                                <span class="text-warning"><small>{{ round($data, 2) }}</small></span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (collect($log->data->long_sign)->values() as $key => $data)
                                            @if ($key == 0)
                                                @if ($data == 1)
                                                    Y
                                                @else
                                                    N
                                                @endif
                                            @else
                                                <span class="text-warning">
                                                    <small>
                                                        @if ($data == 1)
                                                            Y
                                                        @else
                                                            N
                                                        @endif
                                                    </small>
                                                </span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (collect($log->data->long_close)->values() as $key => $data)
                                            @if ($key == 0)
                                                @if ($data == 1)
                                                    Y
                                                @else
                                                    N
                                                @endif
                                            @else
                                                <span class="text-warning">
                                                    <small>
                                                        @if ($data == 1)
                                                            Y
                                                        @else
                                                            N
                                                        @endif
                                                    </small>
                                                </span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $action = $log->action[1];
                                            $class = '';
                                            
                                            if ($action == 'K') {
                                                $class = 'badge-light-info';
                                            } elseif ($action == 'U') {
                                                $class = 'badge-light-success';
                                            } elseif ($action == 'E') {
                                                $class = 'badge-light-danger';
                                            }
                                        @endphp
                                        <span class="badge {{ $class }}">
                                            {{ $log->action[0] }}
                                        </span>
                                        &nbsp;&nbsp;
                                        <small>
                                            {{ $log->created_at->tz('Asia/Jakarta')->isoFormat('ddd MM') }}
                                            {{ $log->created_at->tz('Asia/Jakarta')->isoFormat('HH:mm') }}
                                        </small>
                                    </td>
                                </tr>
                                @php($i++)
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center">No data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Kick start -->
@endsection
