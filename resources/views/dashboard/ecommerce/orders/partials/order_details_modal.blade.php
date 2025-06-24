<div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailsModalLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel{{ $order->id }}">Order #{{ $order->order_no }} Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Customer Info -->
                <h6 class="mb-3">Customer Information</h6>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Name:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ $order->user->phone_number ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Address:</strong> {{ $order->user->address ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>City:</strong> {{ $order->user->city ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>State:</strong> {{ $order->user->state ?? 'N/A' }}</li>
                </ul>

                <!-- Order Status Form -->
                <form action="{{ route('orders.update.status', $order->id) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="statusSelect{{ $order->id }}" class="form-label"><strong>Order Status</strong></label>
                            <select name="status" id="statusSelect{{ $order->id }}" class="form-select">
                                @foreach (['Pending', 'Ongoing', 'Completed', 'Cancelled'] as $status)
                                    <option value="{{ $status }}" @selected($order->status == $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                        </div>
                    </div>
                </form>

                <!-- Order Summary -->
                <h6 class="mb-3">Order Summary</h6>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Delivery Method:</strong> {{ $order->delivery_method }}</li>
                    @if (strtolower($order->delivery_method) === 'door delivery')
                        <li class="list-group-item"><strong>Delivery Fee:</strong> ₦{{ number_format($order->delivery_fee, 2) }}</li>
                    @endif
                    <li class="list-group-item"><strong>Subtotal:</strong> ₦{{ number_format($order->subtotal_price, 2) }}</li>
                    <li class="list-group-item"><strong>Total:</strong> ₦{{ number_format($order->total_price, 2) }}</li>
                    <li class="list-group-item"><strong>Payment Method:</strong> {{ $order->payment_method ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Payment Status:</strong>
                        <span class="badge bg-{{ $order->payment_status == 'Paid' ? 'success' : 'warning' }}">
                            {{ $order->payment_status }}
                        </span>
                    </li>
                    <li class="list-group-item"><strong>Order Date:</strong> {{ $order->created_at->format('d M Y h:i A') }}</li>
                </ul>

                <!-- Items Table -->
                <h6 class="mb-3">Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->product->size ?? 'N/A' }}</td>
                                    <td>₦{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>₦{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
