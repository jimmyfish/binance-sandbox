@extends('layouts/contentLayoutMaster')

@section('title', 'Watchlists')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">What is page layout?</h4>
        </div>
        <div class="card-body">
            <div class="card-text">
                <p>
                    Starter kit includes pages with different layouts, useful for your next project to start development
                    process
                    from scratch with no time.
                </p>
                <ul>
                    <li>Each layout includes required only assets only.</li>
                    <li>
                        Select your choice of layout from starter kit, customize it with optional changes like colors and
                        branding,
                        add required dependency only.
                    </li>
                </ul>
                <div class="alert alert-primary" role="alert">
                    <div class="alert-body">
                        <strong>Info:</strong> Please check that symbol has an active status, or it will not executed.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Kick start -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Symbol to be executed by watcher 🚀</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Symbol</th>
                            <th>Status</th>
                            <th>Date added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($watchlists as $watchlist)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $watchlist->symbol }}</span>
                                </td>
                                <td><span class="badge rounded-pill badge-light-primary me-1">Active</span></td>
                                <td><span>{{ $watchlist->created_at }}</span></td>
                                <td>
                                    <a href="#">
                                        <i data-feather="edit-2" class="me-50"></i>
                                    </a>
                                    <a href="#">
                                        <i data-feather="trash" class="me-50"></i>
                                    </a>
                                    {{-- <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                            data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            
                                        </div>
                                    </div> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Kick start -->
@endsection
