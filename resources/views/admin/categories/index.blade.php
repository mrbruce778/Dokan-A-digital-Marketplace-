@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 class="text-primary" style="margin-bottom: 20px;">Categories</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center; margin-bottom: 30px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 25px; justify-content: center; padding: 20px;">
        @forelse($categories as $category)
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
                
                <!-- Category ID -->
                <div style="
                    background: #007bff; 
                    color: white; 
                    width: 40px; 
                    height: 40px; 
                    border-radius: 50%; 
                    display: flex; 
                    align-items: center; 
                    justify-content: center; 
                    margin: 0 auto 15px auto;
                    font-weight: bold;
                ">
                    {{ $category->category_id }}
                </div>

                <!-- Category Name -->
                <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">
                    {{ $category->category_name }}
                </h4>

                <!-- Category Image -->
                <div style="margin-bottom: 15px;">
                    @if($category->image_url)
                        <img src="{{ $category->image_url }}" 
                             alt="{{ $category->category_name }}" 
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

                <!-- Parent Category -->
                <div style="margin-bottom: 20px; color: #666;">
                    <small><strong>Parent ID:</strong> {{ $category->parent_category_id ?? 'None' }}</small>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="btn btn-sm btn-warning" 
                       style="flex: 1; max-width: 80px;">
                        Edit
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                          method="POST" 
                          style="flex: 1; max-width: 80px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-sm btn-danger" 
                                style="width: 100%;"
                                onclick="return confirm('Delete this category?')">
                            Delete
                        </button>
                    </form>

                </div>
                <a href="{{ route('admin.products.index', $category) }}" 
                class="btn btn-sm btn-info" 
                style="flex: 1; max-width: 80px; max-height: 40px; margin-top: 10px; font-size: 12px;">
                    Manage Products
                </a>

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
                <h4>No categories found.</h4>
                <p>Click "Add New Category" to create your first category.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection