@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-4 text-center">Edit Category</h2>

    <form action="{{ route('admin.categories.update', $category->category_id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Category Name -->
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" name="category_name" id="category_name" 
                   value="{{ old('category_name', $category->category_name) }}" 
                   class="form-control @error('category_name') is-invalid @enderror" required>
            @error('category_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Image URL -->
        <div class="mb-3">
            <label for="image_url" class="form-label">Image URL</label>
            <input type="text" name="image_url" id="image_url" 
                   value="{{ old('image_url', $category->image_url) }}" 
                   class="form-control @error('image_url') is-invalid @enderror">
            @error('image_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Parent Category -->
        <div class="mb-3">
            <label for="parent_category_id" class="form-label">Parent Category ID</label>
            <input type="number" name="parent_category_id" id="parent_category_id" 
                   value="{{ old('parent_category_id', $category->parent_category_id) }}" 
                   class="form-control @error('parent_category_id') is-invalid @enderror">
            @error('parent_category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </div>
    </form>
</div>
@endsection
