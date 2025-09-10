@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 class="text-primary" style="margin-bottom: 20px;">Products in {{ $category->category_name }}</h2>
        <a href="{{ route('admin.products.create', $category->category_id) }}" class="btn btn-success">
            Add New Product
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">
            Back to Categories
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 25px; justify-content: center; padding: 20px;">
        @forelse($products as $product)
            <div style="
                width: 300px; 
                background: white; 
                border-radius: 12px; 
                padding: 20px; 
                text-align: center;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border: 1px solid #e0e0e0;
            " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.15)'" 
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.1)'">
                
                <!-- Product Name -->
                <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">
                    {{ $product->name }}
                </h4>

                <!-- Product Image -->
                <div style="margin-bottom: 15px;">
                    @if($product->gallery->first()?->image_url)
                        <img src="{{ $product->gallery->first()->image_url }}" 
                            alt="{{ $product->name }}" 
                            style="
                                width: 100px; 
                                height: 100px; 
                                object-fit: cover; 
                                border-radius: 8px; 
                                border: 2px solid #f0f0f0;
                            ">


                    @else
                        <div style="
                            width: 100px; 
                            height: 100px; 
                            background: #f8f9fa; 
                            border: 2px dashed #dee2e6; 
                            border-radius: 8px; 
                            display: flex; 
                            align-items: center; 
                            justify-content: center; 
                            margin: 0 auto;
                            color: #6c757d;
                        ">
                            No Image
                        </div>
                    @endif
                </div>

                <!-- Product Price -->
                <div style="margin-bottom: 15px; color: #666;">
                    <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                </div>

                <!-- Stock -->
                <div style="margin-bottom: 20px; color: #666;">
                    <strong>Stock:</strong> {{ $product->stock ?? 'N/A' }}
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="btn btn-sm btn-warning" style="flex: 1; max-width: 80px;">
                        Edit
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" 
                          method="POST" 
                          style="flex: 1; max-width: 80px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-sm btn-danger" 
                                style="width: 100%;"
                                onclick="return confirm('Delete this product?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="
                text-align: center; 
                padding: 50px; 
                color: #666;
                background: white;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                margin: 20px;
            ">
                <h4>No products found in this category.</h4>
                <p>Click "Add New Product" to create one.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
