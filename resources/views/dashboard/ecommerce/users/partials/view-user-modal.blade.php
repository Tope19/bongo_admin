@foreach ($users as $user)
<!-- View User Modal -->
<div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="viewUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Details - {{ $user->first_name }} {{ $user->last_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>First Name:</strong> {{ $user->first_name }}</li>
                    <li class="list-group-item"><strong>Last Name:</strong> {{ $user->last_name }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>Phone 1:</strong> {{ $user->phone_number ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Phone 2:</strong> {{ $user->phone_number2 ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Role:</strong> {{ $user->role ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Address:</strong> {{ $user->address ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>City:</strong> {{ $user->city ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>State:</strong> {{ $user->state ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Status:</strong>
                        <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($user->status) }}</span>
                    </li>
                    <li class="list-group-item"><strong>Email Verified:</strong>
                        {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y h:i A') : 'Not Verified' }}
                    </li>
                    <li class="list-group-item"><strong>Last Login:</strong>
                        {{ $user->last_login_at ? $user->last_login_at->format('d M Y h:i A') : 'Never' }}
                    </li>
                    <li class="list-group-item"><strong>Apple ID:</strong> {{ $user->apple_id ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>FCM Token:</strong>
                        <div class="text-truncate" style="max-width: 100%;">{{ $user->fcm_token ?? 'N/A' }}</div>
                    </li>
                    <li class="list-group-item"><strong>Registered:</strong>
                        {{ $user->created_at ? $user->created_at->format('d M Y h:i A') : 'N/A' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endforeach
