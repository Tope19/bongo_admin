<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\LogisticOrder;
use App\Models\LogisticPayment;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $processedCourierRequests = LogisticOrder::where('status', 'Completed')->count();
        // gettig the total revenue would be getting the sum of payments table and logistic_payments table
        $totalRevenue = Payment::where('status', 'Success')->sum('amount')
               + LogisticPayment::where('status', 'Success')->sum('amount');

        $totalRevenue = number_format($totalRevenue, 2); // e.g. 45,000.00
        $orders = Order::with('items.product')->latest()->get();
        $logistics = LogisticOrder::with([
            'user:id,first_name,last_name',
            'pickupLocation:id,address',
            'packageType:id,name',
            'dropoffs:id,logistic_order_id,recipient_name,address,phone_number,price'
        ])
        ->latest()
        ->get();

        $totalOrders = Order::distinct('orders.id')->count();
        return view('dashboard.index', compact('processedCourierRequests', 'logistics', 'totalRevenue', 'orders', 'totalOrders'));

    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Ongoing,Completed,Cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
    }

    public function updateLogisticStatus(Request $request, LogisticOrder $logisticOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Ongoing,Completed,Cancelled',
            '_state' => 'required|in:Orders Received,On the way,Delivered at drop off location',
        ]);

        $logisticOrder->update($validated);

        return back()->with('success', 'Logistic order status updated.');
    }



}
