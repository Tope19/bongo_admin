<?php

namespace App\Http\Controllers\Admin\Logistics;

use Illuminate\Http\Request;
use App\Models\LogisticOrder;
use App\Http\Controllers\Controller;

class LogisticOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logistics = LogisticOrder::with([
            'user:id,first_name,last_name',
            'pickupLocation:id,address',
            'packageType:id,name',
            'dropoffs:id,logistic_order_id,recipient_name,address,phone_number,price'
        ])
        ->latest()
        ->get();
        return view('dashboard.logistics.orders.index', compact('logistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Ongoing,Completed,Cancelled',
            '_state' => 'required|in:Orders Received,On the way,Delivered at drop off location',
        ]);

        $order = LogisticOrder::findOrFail($id);

        $order->status = $request->status;
        $order->_state = $request->_state;
        $order->save();

        return back()->with('success', 'Logistic Order status and state updated successfully.');
    }
}
