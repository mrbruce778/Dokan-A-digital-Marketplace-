<!-- @extends('dashboard')

@section('head')
@vite('resources/css/dashboard.css')
@endsection

@section('content')
<h1>{{ $category->category_name }}</h1>

<div class="shop-sec">
    @if($products->count() > 0)
        @foreach($products as $product)
            <div class="box">
                <div class="product-content">
                    <h2>{{ $product->name }}</h2>
                    @if($product->image_url)
                        <div class="box-img" style="background-image: url('{{ $product->image_url }}'); background-size: cover; background-position: center; width: 100%; height: 200px;"></div>
                    @endif
                    <p>{{ $product->description }}</p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p>
                        <a href="{{ route('payment.cart', ['product_id' => $product->product_id]) }}" class="btn-success add-to-cart-btn">
                            Add to Cart
                        </a>
                    </p>
                </div>
            </div>
        @endforeach
    @else
        <p>No products available in this category.</p>
    @endif
</div>
@endsection -->