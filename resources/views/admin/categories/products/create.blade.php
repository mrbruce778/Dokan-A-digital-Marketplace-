@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-4 text-center">Add New Product</h2>

    <form action="{{ route('admin.products.store', $category->category_id) }}" 
          method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name') }}" 
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
                      required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price ($)</label>
            <input type="number" name="price" id="price" step="0.01"
                   value="{{ old('price') }}" 
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
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" 
                        {{ old('category_id', $category->category_id) == $cat->category_id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Product Image -->
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
            <a href="{{ route('admin.products.index', $category->category_id) }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Add Product</button>
        </div>
    </form>
</div>
@endsection
