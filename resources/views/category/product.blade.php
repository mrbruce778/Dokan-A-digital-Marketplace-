@extends('dashboard')

@section('header')
<style>
button.add-to-cart-btn {
    background: #f0c14b;
    border: 1px solid #a88734 #9c7e31 #846a29;
    color: #111;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
}

.add-to-cart-btn:hover {
    background: #ddb347;
}

.add-to-cart-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.add-to-cart-form {
    display: inline;
}

.quantity-input {
    width: 60px;
    padding: 5px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin: 0 10px;
}

.quantity-label {
    font-weight: bold;
    margin-right: 10px;
}
</style>
@endsection

@section('content')
<h1>{{ $category->category_name }}</h1>

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

<div class="shop-sec">
    @if($products->count() > 0)
        @foreach($products as $product)
            @if($product->status != 'sold')
                <div class="box">
                    <div class="product-content">
                        <h2>{{ $product->name }}</h2>
                        @if($product->gallery->first())

                            <img src="{{$product->gallery->first()->image_url }}" 
                                alt="{{ $product->gallery->first()->alt_text ?? $product->name }}"
                                width="200">
                        @endif
                        <p>{{ $product->description }}</p>
                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <p>
                            <form method="POST" action="{{ route('cart.add', $product->product_id) }}" class="add-to-cart-form">
                                @csrf
                                <label class="quantity-label">Quantity:</label>
                                <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                                <button type="submit" class="add-to-cart-btn">
                                    <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        </p>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <p>No products available in this category.</p>
    @endif
</div>
@endsection