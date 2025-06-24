@extends('dashboard.layouts.app', ['title' => 'Package Types'])

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Logistics</a></li>
        <li class="breadcrumb-item active" aria-current="page">Package Types</li>
    </ol>
</nav>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Package Types</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPackageModal">
                        Add Package Type
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="dataTableExample" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price Multiplier</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($packageTypes as $index => $type)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>{{ $type->description ?? '-' }}</td>
                                    <td>{{ $type->price_multiplier }}</td>
                                    <td>
                                        <span class="badge bg-{{ $type->is_active ? 'success' : 'secondary' }}">
                                            {{ $type->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $type->created_at?->format('d M Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#editPackageModal{{ $type->id }}">Edit</button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deletePackageModal{{ $type->id }}">Delete</button>
                                    </td>
                                </tr>


                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No package types found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Create Modal --}}
@include('dashboard.logistics.package-types.partials.create-modal')

@foreach ($packageTypes as $type)
{{-- Edit Modal --}}
@include('dashboard.logistics.package-types.partials.edit-modal')

{{-- Delete Modal --}}
@include('dashboard.logistics.package-types.partials.delete-modal')
@endforeach

@endsection
