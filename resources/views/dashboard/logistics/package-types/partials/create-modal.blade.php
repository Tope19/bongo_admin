<div class="modal fade" id="createPackageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('package-types.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add Package Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label>Price Multiplier</label>
                    <input type="number" step="0.01" name="price_multiplier" class="form-control" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="is_active" class="form-check-input" id="create_is_active" checked>
                    <label for="create_is_active" class="form-check-label">Active</label>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Add</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
            </div>
        </form>
    </div>
</div>
