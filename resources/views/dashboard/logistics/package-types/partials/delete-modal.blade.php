<!-- Delete Modal -->
                <div class="modal fade" id="deletePackageModal{{ $type->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('package-types.destroy', $type->id) }}" class="modal-content">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Package Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <strong>{{ $type->name }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" type="submit">Delete</button>
                                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
