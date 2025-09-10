@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-3">All Orders</h2>

    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Payment Method</th>
                    <th>Progress Status</th>
                    <th> Customer Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{  $order->total_amount  }}</td>
                        <td>{{  $order->payment_method  }}</td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-flex align-items-center justify-content-center">
                                @csrf
                                <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                    <option value="Pending" {{ $order->progress_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ $order->progress_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Returned" {{ $order->progress_status == 'Returned' ? 'selected' : '' }}>Returned</option>
                                    <option value="Cancelled" {{ $order->progress_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>

                            </form>
                        </td>
                        <td>{{ $order->customer ? $order->customer->name : 'N/A' }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{  $order->phone_number }}</td>
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
