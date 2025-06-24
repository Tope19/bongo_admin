<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteProductModalLabel{{ $product->id }}">
    <div class="modal-dialog">
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the product <strong>{{ $product->name }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
