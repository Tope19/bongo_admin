<!-- Edit Modal -->
                <div class="modal fade" id="editPackageModal{{ $type->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('package-types.update', $type->id) }}" class="modal-content">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Package Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $type->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control">{{ $type->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Price Multiplier</label>
                                    <input type="number" step="0.01" name="price_multiplier" class="form-control" value="{{ $type->price_multiplier }}" required>
                                </div>
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active{{ $type->id }}" {{ $type->is_active ? 'checked' : '' }}>
                                    <label for="is_active{{ $type->id }}" class="form-check-label">Active</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

