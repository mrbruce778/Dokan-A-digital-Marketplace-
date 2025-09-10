@extends('dashboard')
<style>
.checkout-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
}
.checkout-container h1 {
    margin-bottom: 20px;
    color: #333;
}
.checkout-container p {
    font-size: 16px;
    color: #555;
    margin-bottom: 10px;
}
.checkout-container .order-details {
    text-align: left;
    margin: 20px 0;
}
.checkout-container .order-details p {
    margin: 5px 0;
}

.checkout-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}
.checkout-btn:hover {
    background-color: #0056b3;
}
</style>
@section('content')
<div class="checkout-container">
    <h1>Thank you for your order!</h1>
    <p>Your order has been placed successfully.</p>

    <div class="order-details">
        <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
        <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Payment Method:</strong> {{ $paymentMethods[$order->payment_method] ?? 'Unknown' }}</p>
        <p><strong>Delivery Address:</strong> {{ $order->address }}</p>
        <p><strong>Phone Number:</strong> {{ $order->phone_number }}</p>
    </div>
    @if($order->payment_method != 1)
        <a href="{{ route('checkout1') }}" class="checkout-btn" id="sslczPayBtn">
            <i class="fa-solid fa-credit-card"></i> Pay with SSLCommerz
        </a>
    @else
        <div class="cod-message">
            <i class="fa-solid fa-truck"></i> 
            <strong>Cash on Delivery Selected</strong><br>
            Your order will be processed and delivered to you soon. You can pay when the product arrives.
        </div>
    @endif

    <a href="{{ route('dashboard') }}" class="checkout-btn">
        <i class="fa-solid fa-house"></i> Back to Home
    </a>
</div>
@endsection
<script>
    var obj = {};
    obj.cus_name = "{{ $order->order_id ?? 'Guest' }}";
    obj.cus_phone = "{{ $order->phone_number ?? 'N/A' }}";
    obj.cus_email = "{{ $order->customer_email ?? 'shajedultoky123@gmail.com' }}";
    obj.cus_addr1 = "{{ $order->address ?? 'N/A' }}";
    obj.amount = "{{ $order->total_amount }}";  // Must be numeric

    // Attach the data to the SSLCommerz button
    document.getElementById('sslczPayBtn').setAttribute('postdata', JSON.stringify(obj));
</script>

<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };
    
        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>