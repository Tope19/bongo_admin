<?php

namespace App\Http\Controllers\Admin\Logistics;

use App\Models\PackageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PackageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packageTypes = PackageType::latest()->get();
        return view('dashboard.logistics.package-types.index', compact('packageTypes'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_multiplier' => 'required|min:0',
            'is_active' => 'nullable',
        ]);

        PackageType::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_multiplier' => $request->price_multiplier,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Package Type created successfully.');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageType $packageType)
    {
        $packageType->delete();
        return back()->with('success', 'Package Type deleted.');
    }

    public function update(Request $request, PackageType $packageType)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price_multiplier' => 'nullable|min:0',
            'is_active' => 'nullable',
        ],[
            'name.required' => 'The name field is required.',
            'description.required' => 'The description field is required.',
            'price_multiplier.required' => 'The price multiplier field is required.',
            'is_active.required' => 'The is active field is required.',
        ]);

        try {
            DB::beginTransaction();

            $packageType->update([
                'name' => $request->name,
                'description' => $request->description,
                'price_multiplier' => $request->price_multiplier,
                'is_active' => $request->has('is_active'),
            ]);

            DB::commit();

            return back()->with('success', 'Package Type updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Failed to update Package Type', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Failed to update Package Type. Please try again.');
        }
    }
}
