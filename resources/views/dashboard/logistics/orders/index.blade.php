@extends('dashboard.layouts.app', ['title' => 'Order List'])

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders List</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Logistics Orders</h4>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Order No.</th>
                                    <th>Customer Name</th>
                                    <th>Pickup Location</th>
                                    <th>Package Type</th>
                                    <th>Distance (km)</th>
                                    <th>Weight (kg)</th>
                                    <th>Total Price</th>
                                    <th>Payment Status</th>
                                    <th>Status</th>
                                    <th>Current State</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logistics as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->user->first_name ?? '' }} {{ $order->user->last_name ?? '' }}</td>
                                        <td>{{ $order->pickupLocation->address ?? 'N/A' }}</td>
                                        <td>{{ $order->packageType->name ?? 'N/A' }}</td>
                                        <td>{{ $order->total_distance ?? 0 }}</td>
                                        <td>{{ $order->weight ?? 0 }}</td>
                                        <td>₦{{ number_format($order->total_price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->payment_status === 'Paid' ? 'success' : 'warning' }}">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'Completed' ? 'success' : 'secondary' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="badge bg-info">{{ $order->_state }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#logisticModal{{ $order->id }}">
                                                View
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Logistic Order Modal --}}
                                    <div class="modal fade" id="logisticModal{{ $order->id }}" tabindex="-1"
                                        aria-labelledby="logisticModalLabel{{ $order->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Order #{{ $order->order_number }} Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <p><strong>Customer:</strong> {{ $order->user->first_name ?? '' }} {{ $order->user->last_name ?? '' }}</p>
                                                    <p><strong>Pickup Address:</strong> {{ $order->pickupLocation->address ?? 'N/A' }}</p>
                                                    <p><strong>Package Type:</strong> {{ $order->packageType->name ?? 'N/A' }}</p>
                                                    <p><strong>Total Distance:</strong> {{ $order->total_distance }} km</p>
                                                    <p><strong>Weight:</strong> {{ $order->weight }} kg</p>
                                                    <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                                                    <p><strong>Current State:</strong> {{ $order->_state }}</p>

                                                    <form action="{{ route('logistics.update.status', $order->id) }}"
                                                        method="POST" class="mb-3">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <label><strong>Order Status:</strong></label>
                                                            <select name="status" class="form-select">
                                                                @foreach (['Pending', 'Ongoing', 'Completed', 'Cancelled'] as $status)
                                                                    <option value="{{ $status }}" @selected($order->status == $status)>
                                                                        {{ $status }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label><strong>Delivery State:</strong></label>
                                                            <select name="_state" class="form-select">
                                                                @foreach (['Orders Received', 'On the way', 'Delivered at drop off location'] as $state)
                                                                    <option value="{{ $state }}" @selected($order->_state == $state)>
                                                                        {{ $state }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                                                    </form>

                                                    <h6>Dropoffs:</h6>
                                                    @php $subtotal = 0; @endphp
                                                    <ul class="list-group">
                                                        @forelse ($order->dropoffs as $dropoff)
                                                            @php $subtotal += $dropoff->price ?? 0; @endphp
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <div>
                                                                    {{ $dropoff->recipient_name }}<br>
                                                                    {{ $dropoff->address }}<br>
                                                                    Phone: {{ $dropoff->phone_number }}
                                                                </div>
                                                                <span>₦{{ number_format($dropoff->price ?? 0, 2) }}</span>
                                                            </li>
                                                        @empty
                                                            <li class="list-group-item text-center">No dropoffs listed.</li>
                                                        @endforelse
                                                    </ul>

                                                    <hr>
                                                    <p><strong>Sub Total:</strong> ₦{{ number_format($subtotal, 2) }}</p>
                                                    <p><strong>Total:</strong> ₦{{ number_format($order->total_price, 2) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No logistic orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
