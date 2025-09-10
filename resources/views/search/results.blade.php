@extends('dashboard')

@section('content')
<div class="search-results-container">
    <h2>Search Results for "{{ $query }}"</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if($products->count() > 0)
        <h3>Products</h3>
        <ul>
            @foreach($products as $product)
                <li>
                    <span class="product-name">{{ $product->name }}</span>
                    <span class="product-price">${{ $product->price ?? '0.00' }}</span>

                    <!-- Add to Cart Button -->
                    <form method="POST" action="{{ route('cart.add', $product->product_id) }}" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p style="text-align:center; color:#7f8c8d;">No products found.</p>
    @endif

    @if($recommendations->count() > 0)
        <h3>Recommended Products</h3>
        <ul>
            @foreach($recommendations as $rec)
                <li>
                    <span class="product-name">{{ $rec->name }}</span>
                    <span class="product-price">${{ $rec->price ?? '0.00' }}</span>

                    <!-- Add to Cart Button -->
                    <form method="POST" action="{{ route('cart.add', $rec->product_id) }}" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
