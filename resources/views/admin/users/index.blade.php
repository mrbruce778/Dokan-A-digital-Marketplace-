@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-3 text-center">All Users</h2>

    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Admin?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->customer_id ?? 'N/A' }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $user->is_admin ? 'success' : 'secondary' }}">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.users.toggleAdmin', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">
                                    {{ $user->is_admin ? 'Revoke Admin' : 'Make Admin' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
