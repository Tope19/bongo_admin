@extends('dashboard.layouts.app', ['title' => 'User List'])

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Users</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Users</h4>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone_number ?? '-' }}</td>
                                        <td>
                                            @php
                                                $isActive = (int) $user->status === 1;
                                            @endphp
                                            <span class="badge bg-{{ $isActive ? 'success' : 'danger' }}">
                                                {{ $isActive ? 'Active' : 'Blocked' }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <!-- View Button -->
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#viewUserModal{{ $user->id }}">
                                                View
                                            </button>

                                            <!-- Block/Unblock Button -->
                                            <button class="btn btn-sm btn-{{ $user->status == 1 ? 'danger' : 'success' }}"
                                                data-bs-toggle="modal" data-bs-target="#blockUserModal{{ $user->id }}">
                                                {{ $user->status == 1 ? 'Block' : 'Unblock' }}
                                            </button>

                                        </td>

                                    </tr>


                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @foreach ($users as $user)
        @include('dashboard.ecommerce.users.partials.view-user-modal')
        @include('dashboard.ecommerce.users.partials.block-user-modal')
    @endforeach
@endsection
