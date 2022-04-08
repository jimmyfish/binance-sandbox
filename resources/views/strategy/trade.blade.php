@extends('layouts/contentLayoutMaster')

@section('title', 'Trade Strategy')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Symbol</th>
                            <th>Timestamp</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tradeStrategies->count() > 0)
                            @foreach ($tradeStrategies as $tradeStrategy)
                                <tr>
                                    <td>
                                        {{ $tradeStrategy->symbol }}
                                    </td>
                                    <td>{{ $tradeStrategy->timestamp }}</td>
                                    <td>
                                        <small>
                                            @if ($tradeStrategy->trashed())
                                                <span class="text-danger">NO</span>
                                            @else
                                                <span class="text-success">YES</span>
                                            @endif
                                        </small>
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
