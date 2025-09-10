@extends('dashboard')

@section('content')
<div class="cart-container" style="max-width: 800px; margin: auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <div class="cart-header">
        <h1>Shopping Cart</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    @if($cartItems->count() > 0)
        @foreach($cartItems as $item)
            <div class="cart-item" id="cart-item-{{ $item->cart_item_id }}">
                @if($item->product->image_url)
                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="cart-item-image">
                @else
                    <div class="cart-item-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-image" style="font-size: 24px; color: #999;"></i>
                    </div>
                @endif
                
                <div class="cart-item-details">
                    <div class="cart-item-name">{{ $item->product->name }}</div>
                    <div class="cart-item-price">${{ number_format($item->price_at_purchase, 2) }}</div>
                    <div class="cart-item-quantity">
                        <!-- Quantity update form (kept same logic) -->
                        <form method="POST" action="{{ route('cart.update', $item->cart_item_id) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="action" value="decrease" class="quantity-btn">-</button>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="quantity-input">
                            <button type="submit" name="action" value="increase" class="quantity-btn">+</button>
                        </form>
                    </div>
                </div>
                
                <!-- AJAX Delete Button -->
                <button class="remove-from-cart remove-btn" data-id="{{ $item->cart_item_id }}">
                    <i class="fa-solid fa-trash"></i> Remove
                </button>
            </div>
        @endforeach
        
        <div class="cart-summary">
            <div class="cart-total">
                Total: $<span id="cart-total">{{ number_format($total, 2) }}</span>
            </div>
            <div class="cart-items-count">
                Items: <span id="cart-count">{{ $cartItems->sum('quantity') }}</span>
            </div>
        </div>
        <a href="{{ route('checkout') }}" class="checkout-btn">
            <i class="fa-solid fa-credit-card"></i>Proceed to Checkout
        </a>
        
    @else
        <div class="empty-cart">
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any products to your cart yet.</p>
            <a href="{{ route('dashboard') }}" class="continue-shopping">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on("click", ".remove-from-cart", function(e) {
    e.preventDefault();
    let cartItemId = $(this).data("id");

    if (!confirm("Are you sure you want to remove this item?")) return;

    // Generate URL via Blade
    let url = "{{ route('cart.remove', ':id') }}";
    url = url.replace(':id', cartItemId);

    $.ajax({
        url: url,
        type: "POST", // or DELETE if you want
        data: {
            _token: "{{ csrf_token() }}",
            _method: 'DELETE' // Laravel method spoofing
        },
        success: function(response) {
            if(response.success){
                $("#cart-item-" + cartItemId).remove();
                $("#cart-total").text(response.newTotal.toFixed(2));
                $("#cart-count").text(response.itemCount);
                if(response.cartEmpty){
                    $(".cart-container").html(`
                        <div class="empty-cart">
                            <h2>Your cart is empty</h2>
                            <p>Looks like you haven't added any products to your cart yet.</p>
                            <a href="{{ route('dashboard') }}" class="continue-shopping">Continue Shopping</a>
                        </div>
                    `);
                } else {
                    alert(response.message);
                }
            } else {
                alert(response.message);
            }
        },
        error: function(xhr) {
            console.error(xhr.status, xhr.responseText);
            alert("Error removing item: " + xhr.status);
        }
    });
});

</script>
@endsection
