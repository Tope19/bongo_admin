<!-- Block/Unblock Modal -->
<div class="modal fade" id="blockUserModal{{ $user->id }}" tabindex="-1"
    aria-labelledby="blockUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('users.toggle-status', $user->id) }}" class="modal-content">
            @csrf
            @method('PATCH')
            <div class="modal-header">
                <h5 class="modal-title" id="blockUserModalLabel{{ $user->id }}">
                    {{ $user->status == 1 ? 'Block User' : 'Unblock User' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to
                <strong>{{ $user->status == 1 ? 'block' : 'unblock' }}</strong>
                user <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-{{ $user->status == 1 ? 'danger' : 'success' }}">
                    Yes, {{ $user->status == 1 ? 'Block' : 'Unblock' }}
                </button>
            </div>
        </form>
    </div>
</div>
