<?php

namespace App\Http\Controllers\Admin\Logistics;

use App\Models\PriceSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PriceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = PriceSetting::first();
        return view('dashboard.logistics.price-setting.index', compact('settings'));
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
    public function updateSetting(Request $request)
    {
        $request->validate([
            'base_fare' => 'required|numeric|min:0',
            'price_per_km' => 'required|numeric|min:0',
            'price_per_kg' => 'required|numeric|min:0',
            'min_price' => 'required|numeric|min:0',
        ]);

        $settings = PriceSetting::first();
        if (!$settings) {
            $settings = new PriceSetting();
        }

        $settings->update($request->only(['base_fare', 'price_per_km', 'price_per_kg', 'min_price']));

        return back()->with('success', 'Price settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
