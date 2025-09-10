<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Customer Accounts - Dokan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/dashboard.css')
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

        .customer-accounts-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .page-header {
            background: #232f3e;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            color: #febd69;
        }
        
        .breadcrumb {
            margin-top: 10px;
            font-size: 14px;
        }
        
        .breadcrumb a {
            color: #febd69;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .accounts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .account-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .account-card h3 {
            color: #232f3e;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
            border-bottom: 2px solid #febd69;
            padding-bottom: 10px;
        }
        
        .account-info {
            margin-bottom: 15px;
        }
        
        .account-info p {
            margin: 8px 0;
            color: #555;
        }
        
        .account-info strong {
            color: #232f3e;
        }
        
        .account-actions {
            margin-top: 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background: #febd69;
            color: #232f3e;
        }
        
        .btn-primary:hover {
            background: #f3a847;
        }
        
        .btn-secondary {
            background: #37475a;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #232f3e;
        }
        
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .orders-section {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .orders-section h3 {
            color: #232f3e;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
            border-bottom: 2px solid #febd69;
            padding-bottom: 10px;
        }
        
        .no-orders {
            text-align: center;
            color: #666;
            padding: 40px;
            font-style: italic;
        }
        
        .back-to-dashboard {
            text-align: center;
            margin-top: 30px;
        }
        
        .back-to-dashboard a {
            color: #232f3e;
            text-decoration: none;
            font-weight: bold;
        }
        
        .back-to-dashboard a:hover {
            color: #febd69;
        }
    </style>
</head>
<body>
    @include('layouts.header')

    <main>
        <div class="customer-accounts-container">
            <div class="page-header">
                <h1 class="page-title">Customer Account</h1>
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Home</a> > 
                    <a href="{{ route('customer.accounts') }}">Customer Account</a>
                </div>
            </div>

            <div class="accounts-grid">
                <!-- Personal Information Card -->
                <div class="account-card">
                    <h3><i class="fa-solid fa-user"></i> Personal Information</h3>
                    <div class="account-info">
                        <p><strong>Name:</strong> {{ $customer->name ?? $user->name }}</p>
                        <p><strong>Email:</strong> {{ $customer->email ?? $user->email }}</p>
                        <p><strong>Customer ID:</strong> {{ $customer->customer_id ?? 'N/A' }}</p>
                        <p><strong>Account Type:</strong> 
                            @if(isset($customer) && $customer->guest_flag == 0)
                                <span style="color: #27ae60;">Registered Customer</span>
                            @elseif(isset($customer) && $customer->guest_flag == 1)
                                <span style="color: #f39c12;">Guest Customer</span>
                            @else
                                <span style="color: #e74c3c;">Unknown</span>
                            @endif
                        </p>
                    </div>
                    <div class="account-actions">
                        <a href="#" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>

                <!-- Account Management Card -->
                <div class="account-card">
                    <h3><i class="fa-solid fa-cog"></i> Account Management</h3>
                    <div class="account-info">
                        <p><strong>Member Since:</strong> {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</p>
                        <p><strong>Last Login:</strong> {{ $user->updated_at ? $user->updated_at->format('M d, Y') : 'N/A' }}</p>
                        <p><strong>Status:</strong> <span style="color: #27ae60;">Active</span></p>
                    </div>
                    <div class="account-actions">
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="account-card">
                    <h3><i class="fa-solid fa-bolt"></i> Quick Actions</h3>
                    <div class="account-info">
                    </div>
                    <div class="account-actions">
                        <a href="{{ route('cart.show') }}" class="btn btn-primary">View Cart</a>
                        <a href="#" class="btn btn-secondary">My Wishlist</a>
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
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
            <!-- Back to Dashboard -->
            <div class="back-to-dashboard">
                <a href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </main>

    <script>
        // Load cart count
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.count + ' items';
            })
            .catch(error => {
                document.getElementById('cart-count').textContent = '0 items';
            });
    </script>
</body>
</html>
