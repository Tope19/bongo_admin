@extends('dashboard.layouts.app', ['title' => 'Logistic Transactions'])

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Ecommerce</a></li>
            <li class="breadcrumb-item active" aria-current="page">Transactions</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Transaction List</h4>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order No.</th>
                                    <th>Customer Name</th>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $key => $transaction)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>#{{ $transaction->order->order_no ?? 'N/A' }}</td>
                                        <td>{{ $transaction->order->user->first_name ?? '' }} {{ $transaction->order->user->last_name ?? '' }}</td>
                                        <td>{{ $transaction->reference }}</td>
                                        <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->status === 'Success' ? 'success' : ($transaction->status === 'Pending' ? 'warning' : 'danger') }}">
                                                {{ $transaction->status }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->created_at->format('d M Y h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No transactions found.</td>
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
