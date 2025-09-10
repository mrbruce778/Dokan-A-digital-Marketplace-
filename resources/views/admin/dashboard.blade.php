<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    {{-- Include Bootstrap for quick styling --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            min-width: 200px;
            max-width: 250px;
            background-color: #343a40;
            color: #fff;
            min-height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .main-wrapper {
            flex: 1;
            display: flex;
        }
        footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
    @yield('styles')
</head>
<body>
    {{-- Header --}}
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Admin Panel</a>
                <div class="d-flex">
                    <span class="navbar-text text-white me-3">
                        {{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    {{-- Main Content Area --}}
    <main class="main-wrapper">
        {{-- Sidebar --}}
        <div class="sidebar">
            <a href="{{route('admin.dashboard')}}">Dashboard</a>
            <a href="{{ route('admin.users.index') }}">Manage Users</a>
            <a href="{{ route('admin.orders.index') }}">Manage Orders</a>
            <a href="{{ route('admin.categories.index') }}">Manage Categories</a>
            <a href="{{ route('admin.support.issues') }}">Reports</a>
            <a href="#">Settings</a>
        </div>

        {{-- Main Content --}}
        <div class="content">
            @hasSection('content')
                @yield('content')
            @else
                {{-- Default Dashboard Content --}}
                <h1>Welcome, {{ Auth::user()->name}}!</h1>
                <p>This is your admin dashboard.</p>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card text-bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <p class="card-text">Quick overview of all users.</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">View Users</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Orders</h5>
                                <p class="card-text">Monitor recent orders.</p>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-light btn-sm">View Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Categories & products</h5>
                                <p class="card-text">Manage your categories and product catalog.</p>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-sm">View Categories & Products</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Reviews & Feedback</h5>
                                <p class="card-text">Look through the customer Feedbacks.</p>
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-light btn-sm">View Reviews & Feedback</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Customer Support Panle</h5>
                                <p class="card-text">Look through the reported issues.</p>
                                <a href="{{ route('admin.support.issues') }}" class="btn btn-light btn-sm">View and Resolve Issue</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    {{-- Footer --}}
    <footer>
        <div class="container-fluid text-center">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} Admin Panel. All rights reserved.</p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>