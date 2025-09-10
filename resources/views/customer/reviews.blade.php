@extends('dashboard')

<style>
body{
    align-items: center;
    margin-left: auto;
}
.orders-container {
    padding: 20px;
    background-color: #f9f9f9;
    min-height: 100vh;
    max-width: 50%;
    margin: auto;
}
.order-wrapper {
    align-items: center;
    margin: auto;

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
.alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-error   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

.order-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.feedback-form{
    align-items: center ;
}
.order-actions { margin-top: 20px;
    text-align: center;
    max-width:  60%;
    align-items: center;
}
.order-items { margin-bottom: 20px; }
.items-title { font-size: 18px; margin-bottom: 10px; color: #333; }

.items-list .item-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}
.item-details { max-width: 70%; }
.item-name { font-weight: 600; color: #333; }
.item-qty { color: #555; }
.item-price { font-weight: 600; }

.form-group { margin-bottom: 1rem;
            border-radius: 5px;
            padding: 10px;
            background: azure;
            max-width: 50%;
            align-items: center;
            margin-left: auto;

}
.form-group label { font-weight: 600; display: block; margin-bottom: 0.5rem; }
.form-control {
    flex: auto;
    width: 100%;
    padding: 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid #ccc;
    align-content: center;
}
#rating{
    max-width: 100px;
    appearance: none;
    background: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><polygon points="10,15 4,18 5,11 1,7 8,6 10,0 12,6 19,7 15,11 16,18" fill="%23333"/></svg>') no-repeat right 0.75rem center/1rem auto;
    background-color: #fff;
    padding-right: 2.5rem;
    cursor: pointer;
    
}
.error-message { color: red; margin-top: 0.25rem; }

.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
}

.btn-primary { background-color: #2563eb; color: #fff;
    margin-top: 10px;
 }
.btn-primary:hover { background-color: #bdc4d9ff; }

.btn-secondary { background-color: #6b7280; color: #fff; }
.btn-secondary:hover { background-color: #4b5563; }

.back-link { margin-top: 1.5rem; }
</style>

@section('content')
<div class="orders-container">
    <div class="orders-wrapper">
        <h1 class="page-title">Leave Feedback for Order #{{ $order->order_id }}</h1>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="order-card">
            <!-- Order Items -->
            <div class="order-items">
                <h4 class="items-title">Products in this order:</h4>
                <div class="items-list">
                    @foreach($order->items as $item)
                        <div class="item-row">
                            <div class="item-details">
                                <p class="item-name">{{ $item->product->name ?? 'Product not found' }}</p>
                                <p class="item-qty">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <div class="item-price">
                                ${{ number_format($item->price_at_purchase * $item->quantity, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Feedback Form -->
            <div class="order-actions">
                <form method="POST" action="{{ route('customer.submitFeedback', $order->order_id) }}" class="feedback-form">
                    @csrf

                    <div class="form-group">
                        <label for="rating">Rating (1-5):</label>
                        <select name="rating" id="rating" required class="form-control">
                            <option value="">Select Rating</option>
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        @error('rating')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="review_text">Review :</label>
                        <textarea name="review_text" id="review_text" rows="4" class="form-control" placeholder="Write your feedback here..."></textarea>
                        @error('review_text')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </div>

                    
                </form>
            </div>
        </div>

        <div class="back-link">
            <a href="{{ route('customer.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
        </div>
    </div>
</div>
@endsection


