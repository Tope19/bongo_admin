<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Category Name -->
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label">Description (optional)</label>
                    <textarea name="description" class="form-control" rows="2">{{ $category->description }}</textarea>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" @selected($category->status == 1)>Active</option>
                        <option value="0" @selected($category->status == 0)>Inactive</option>
                    </select>
                </div>

                <!-- Current Icon Preview -->
                <div class="mb-3">
                    <label class="form-label">Current Icon</label><br>
                    @if($category->icon)
                        <img src="{{ asset($category->icon) }}" alt="Current Icon" width="60">
                    @else
                        <p class="text-muted">No icon uploaded.</p>
                    @endif
                </div>

                <!-- Replace Icon -->
                <div class="mb-3">
                    <label class="form-label">Replace Icon (optional)</label>
                    <input type="file" name="icon" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Category</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
