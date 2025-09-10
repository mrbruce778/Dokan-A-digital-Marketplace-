@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-3">All Issues</h2>

    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Ticket ID</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Time of the submission</th>
                    <th>Customer</th>
                </tr>
            </thead>
            <tbody>
                @forelse($issues as $issue)
                    <tr>
                        <td>{{ $issue->ticket_id }}</td>
                        <td>{{ $issue->issue_subject }}</td>
                        <td>{{ $issue->issue_description }}</td>
                        <td>
                            <form action="{{ route('admin.reviews.updateStatus', $issue) }}" method="POST" class="d-flex align-items-center justify-content-center">
                                @csrf
                                <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                    <option value="Pending" {{ $issue->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ $issue->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Resolved" {{ $issue->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="Closed" {{ $issue->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                </select>

                            </form>
                        </td>

                        <td>{{ $issue->created_at }}</td>
                        <td>{{ $issue->customer ? $issue->customer->name : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">No reviews found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
