@extends('dashboard')
<style>
.orders-container {
    padding: 20px;
    background-color: #f9f9f9;
    min-height: 100vh;
}   
button.btn {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
}
.btn-primary {
    background-color: #2563eb;
    color: white;
}
.btn-primary:hover {
    background-color: #1e40af;
}
.btn-cancel {
    background-color: #dc3545;
    color: white;
}
.btn-cancel:hover {
    background-color: #a71d2a;
}
.btn-return {
    background-color: #ffc107;
    color: #212529;
}
.btn-return:hover {
    background-color: #d39e00;
}
.btn-review {
    background-color: #28a745;
    color: white;
    min-width: 120px;
    text-align: center;
    min-height: 50px;
    line-height: 36px;
    text-decoration: none;
}
.btn-review:hover {
    background-color: #1e7e34;
}
.btn-reviewed {
    background-color: #6c757d;
    color: white;
    cursor: default;
}
.btn-reviewed:hover {
    background-color: #6c757d;
}

.empty-state {
    text-align: center;
    padding: 50px 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.empty-icon {
    width: 60px;
    height: 60px;
    color: #ccc;
    margin-bottom: 20px;
}
.empty-title {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

.empty-text {
    color: #666;
    margin-bottom: 20px;
}
.empty-action .btn {
    padding: 10px 20px;
    font-size: 16px;
}

.orders-wrapper {
    max-width: 900px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.page-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 28px;
    color: #333;
}
.alert-success, .alert-error {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    font-weight: 600;
}
.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
.orders-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.order-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background: #fff;
}
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}
.order-id {
    font-size: 20px;
    color: #333;
}
.order-date {
    color: #666;
    font-size: 14px;
}
.status-wrapper {
    text-align: right;
}
.status-badge {
    padding: 5px 10px;
    border-radius: 12px;
    color: #fff;
    font-size: 12px;
    text-transform: capitalize;
}
.status-pending {
    background-color: #ffc107;
}
.status-shipped {
    background-color: #17a2b8;
}
.status-delivered {
    background-color: #28a745;
}
.status-canceled {
    background-color: #dc3545;
}
.status-completed {
    background-color: #007bff;
}
.order-items {
    margin-bottom: 15px;
}
.items-title {
    font-size: 18px;
    margin-bottom: 10px;
    color: #333;
}
.items-list {
    border-top: 1px solid #eee;
}
.item-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}
.item-details {
    max-width: 70%;
}
.item-name {
    font-weight: 600;
    color: #333;
}
</style>

@section('content')
<div class="orders-container">
    <div class="orders-wrapper">
        <h1 class="page-title">My Orders</h1>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($orders->count() > 0)
            <div class="orders-list">
                @foreach($orders as $order)
                    <div class="order-card">
                        <!-- Order Header -->
                        <div class="order-header">
                            <div class="order-info">
                                <h3 class="order-id">Order #{{ $order->order_id }}</h3>
                                <p class="order-date">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="status-wrapper">
                                <span class="status-badge status-{{ $order->progress_status }}">
                                    {{ ucfirst($order->progress_status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="order-items">
                            <h4 class="items-title">Items:</h4>
                            <div class="items-list">
                                @if($order->items && $order->items->count() > 0)
                                    <ul>
                                        @foreach($order->items as $item)
                                            <li>{{ $item->product_name }} x {{ $item->quantity }} = ${{ number_format($item->price_at_purchase * $item->quantity, 2) }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>Order items not available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Total -->
                        <div class="order-total">
                            <div class="total-row">
                                <span class="total-label">Total Amount:</span>
                                <span class="total-amount">
                                    ${{ number_format($order->items->sum(fn($item) => $item->price_at_purchase * $item->quantity), 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="order-actions">
                            <div class="actions-wrapper">
                                @if($order->progress_status === 'pending')
                                    <form action="{{ route('customer.orders.cancel', $order->order_id) }}" method="POST" class="action-form">
                                        @csrf
                                        <button type="submit" class="btn btn-cancel"
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                            Cancel Order
                                        </button>
                                    </form>
                                @endif

                                @if($order->progress_status === 'completed')
                                    <form action="{{ route('customer.orders.return', $order->order_id) }}" method="POST" class="action-form">
                                        @csrf
                                        <button type="submit" class="btn btn-return"
                                                onclick="return confirm('Are you sure you want to return this order?')">
                                            Return Order
                                        </button>
                                    </form>

                                    @if(!$order->reviewed)
                                        <a href="{{ route('customer.reviews', $order->order_id) }}" class="btn btn-review">
                                            Leave Review
                                        </a>
                                    @else
                                        <span class="btn btn-reviewed">Review Submitted</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-content">
                    <svg class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="empty-title">No orders yet</h3>
                    <p class="empty-text">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                    <div class="empty-action">
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">Start Shopping</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
