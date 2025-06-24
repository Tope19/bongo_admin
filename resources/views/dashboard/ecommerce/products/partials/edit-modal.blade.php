<!-- Edit Product Modal -->
@php
    $categories = \App\Models\ProductCategory::where('status', 1)->get();
@endphp
<div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->id }}">
    <div class="modal-dialog">
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Product - {{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Category -->
                <div class="mb-3">
                    <label for="category{{ $product->id }}" class="form-label">Category</label>
                    <select name="category_id" class="form-select" id="category{{ $product->id }}" required>
                        <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Name -->
                <div class="mb-3">
                    <label for="name{{ $product->id }}" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name{{ $product->id }}" value="{{ $product->name }}" required>
                </div>
                <!-- SKU -->
                <div class="mb-3">
                    <label for="sku{{ $product->id }}" class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" id="sku{{ $product->id }}" value="{{ $product->sku }}">
                </div>
                <!-- Barcode -->
                <div class="mb-3">
                    <label for="barcode{{ $product->id }}" class="form-label">Barcode</label>
                    <input type="text" name="barcode" class="form-control" id="barcode{{ $product->id }}" value="{{ $product->barcode }}">
                </div>
                <!-- Status -->
                <div class="mb-3">
                    <label for="status{{ $product->id }}" class="form-label">Status</label>
                    <select name="status" class="form-select" id="status{{ $product->id }}">
                        <option value="1" @selected($product->status == 1)>Active</option>
                        <option value="0" @selected($product->status == 0)>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
