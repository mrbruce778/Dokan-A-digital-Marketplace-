@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-3">All Reviews</h2>

    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Rating</th>
                    <th>Review Text</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Customer</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->review_id }}</td>
                        <td>{{ $review->rating }}</td>
                        <td>{{ $review->review_text }}</td>
                        <td>{{ $review->review_date }}</td>
                        <td>{{ $review->product ? $review->product->name : 'N/A' }}</td>
                        <td>{{ $review->customer ? $review->customer->name : 'N/A' }}</td>
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
