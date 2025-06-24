@extends('dashboard.layouts.app', ['title' => 'Admin-Dashboard'])
@section('content')
    <style>
        @media print {

            .btn,
            .no-print {
                display: none !important;
            }
        }
    </style>
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Overview</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group date datepicker wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary"><i data-feather="calendar"
                        class=" text-primary"></i></span>
                <input type="text" class="form-control border-primary bg-transparent">
            </div>
            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" onclick="window.print()">
                <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                Print Report
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Orders</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $totalOrders }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Courier Requests Processed</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $processedCourierRequests }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Revenue</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">₦{{ $totalRevenue }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

    <div class="row">

        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Customer Ecommerce Orders</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Order No.</th>
                                    <th>Customer Name</th>
                                    <th>Delivery Method</th>
                                    <th>Delivery Fee</th>
                                    <th>Total Price</th>
                                    <th>Payment Status</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_no }}</td>
                                        <td>{{ $order->user->first_name ?? '' }} {{ $order->user->last_name ?? '' }}</td>
                                        <td>{{ $order->delivery_method }}</td>
                                        <td>₦{{ number_format($order->delivery_fee, 2) }}</td>
                                        <td>₦{{ number_format($order->total_price, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $order->payment_status == 'Paid' ? 'success' : 'warning' }}">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $order->status == 'Completed' ? 'success' : 'secondary' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#orderModal{{ $order->id }}">
                                                View
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Order Detail Modal --}}
                                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1"
                                        aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">Order
                                                        #{{ $order->order_no }} Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Customer:</strong> {{ $order->user->first_name ?? '' }}
                                                        {{ $order->user->last_name ?? '' }}</p>
                                                    <p><strong>Delivery Method:</strong> {{ $order->delivery_method }}</p>
                                                    <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>

                                                    <form action="{{ route('orders.update.status', $order->id) }}"
                                                        method="POST" class="mb-3">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-2">
                                                            <label
                                                                for="statusSelect{{ $order->id }}"><strong>Status:</strong></label>
                                                            <div class="d-flex align-items-center">
                                                                <select name="status" id="statusSelect{{ $order->id }}"
                                                                    class="form-select me-2" style="max-width: 200px;">
                                                                    @foreach (['Pending', 'Ongoing', 'Completed', 'Cancelled'] as $status)
                                                                        <option value="{{ $status }}"
                                                                            @selected($order->status == $status)>
                                                                            {{ $status }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-success">Update</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <h6>Items:</h6>
                                                    <ul class="list-group">
                                                        @foreach ($order->items as $item)
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <div>
                                                                    {{ $item->product->product->name ?? 'N/A' }} (Size ID:
                                                                    {{ $item->product_size_id }})<br>
                                                                    Qty: {{ $item->quantity }}
                                                                </div>
                                                                <span>₦{{ number_format($item->price, 2) }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    <hr>
                                                    <p><strong>Sub Total:</strong>
                                                        ₦{{ number_format($order->subtotal_price, 2) }}</p>

                                                    @if (strtolower($order->delivery_method) === 'door delivery')
                                                        <p><strong>Delivery Fee:</strong>
                                                            ₦{{ number_format($order->delivery_fee, 2) }}</p>
                                                    @endif

                                                    <p><strong>Total:</strong> ₦{{ number_format($order->total_price, 2) }}
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Customer Logistic Courier Requests</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
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
                                            <span
                                                class="badge bg-{{ $order->payment_status == 'Paid' ? 'success' : 'warning' }}">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $order->status == 'Completed' ? 'success' : 'secondary' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <span
                                                    class="badge bg-{{ $order->status === 'Completed' ? 'success' : 'secondary' }}">
                                                    {{ $order->status }}
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ $order->_state }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#logisticModal{{ $order->id }}">
                                                View
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Logistic Detail Modal --}}
                                    <div class="modal fade" id="logisticModal{{ $order->id }}" tabindex="-1"
                                        aria-labelledby="logisticModalLabel{{ $order->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="logisticModalLabel{{ $order->id }}">
                                                        Order #{{ $order->order_number }} Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Customer:</strong> {{ $order->user->first_name ?? '' }}
                                                        {{ $order->user->last_name ?? '' }}</p>
                                                    <p><strong>Pickup Address:</strong>
                                                        {{ $order->pickupLocation->address ?? 'N/A' }}</p>
                                                    <p><strong>Package Type:</strong>
                                                        {{ $order->packageType->name ?? 'N/A' }}</p>
                                                    <p><strong>Total Distance:</strong> {{ $order->total_distance }} km</p>
                                                    <p><strong>Weight:</strong> {{ $order->weight }} kg</p>
                                                    <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
                                                    <p><strong>Current State:</strong> {{ $order->_state }}</p>

                                                    <form action="{{ route('logistics.update.status', $order->id) }}"
                                                        method="POST" class="mb-3">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="mb-3">
                                                            <label for="statusSelect{{ $order->id }}"><strong>Order
                                                                    Status:</strong></label>
                                                            <select name="status" id="statusSelect{{ $order->id }}"
                                                                class="form-select">
                                                                @foreach (['Pending', 'Ongoing', 'Completed', 'Cancelled'] as $status)
                                                                    <option value="{{ $status }}"
                                                                        @selected($order->status == $status)>
                                                                        {{ $status }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="stateSelect{{ $order->id }}"><strong>Delivery
                                                                    State:</strong></label>
                                                            <select name="_state" id="stateSelect{{ $order->id }}"
                                                                class="form-select">
                                                                @foreach (['Orders Received', 'On the way', 'Delivered at drop off location'] as $state)
                                                                    <option value="{{ $state }}"
                                                                        @selected($order->_state == $state)>
                                                                        {{ $state }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <button type="submit"
                                                            class="btn btn-sm btn-success">Update</button>
                                                    </form>

                                                    <h6>Dropoffs:</h6>
                                                    @php $subtotal = 0; @endphp
                                                    <ul class="list-group">
                                                        @forelse($order->dropoffs as $dropoff)
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
                                                            <li class="list-group-item text-center">No dropoffs listed.
                                                            </li>
                                                        @endforelse
                                                    </ul>

                                                    <hr>
                                                    <p><strong>Sub Total:</strong> ₦{{ number_format($subtotal, 2) }}</p>
                                                    <p><strong>Total:</strong> ₦{{ number_format($order->total_price, 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No logistic orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- row -->

@endsection
