@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-4 text-center">Edit Product</h2>

    <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $product->name) }}" 
                   class="form-control @error('name') is-invalid @enderror" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="form-control @error('description') is-invalid @enderror"
                      required>{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price ($)</label>
            <input type="number" name="price" id="price" step="0.01"
                   value="{{ old('price', $product->price) }}" 
                   class="form-control @error('price') is-invalid @enderror" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" 
                    class="form-select @error('category_id') is-invalid @enderror" required>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}"
                        {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        
        <div class="mb-3">
            <label for="image_url" class="form-label">Product Image URL (optional)</label>
            <input type="text" name="image_url" id="image_url" 
                value="{{ old('image_url') }}" 
                class="form-control @error('image_url') is-invalid @enderror" 
                placeholder="Enter full image URL">
            @error('image_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.products.index', $product->category_id) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </form>
</div>
@endsection
