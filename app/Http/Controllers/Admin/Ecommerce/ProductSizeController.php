<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = ProductSize::with('product')
            ->latest()
            ->get();
        $products = Product::where('status', 1)
            ->get();
        return view('dashboard.ecommerce.sizes.index', compact('sizes', 'products'));
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
        try{
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'size' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock_quantity' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                toastr()->error($validator->errors()->first());
                return back();
            }

            $data = $validator->validated();
            $data['status'] = 1;
            ProductSize::create($data);
            DB::commit();
            toastr()->success('Product Size created successfully.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            report_error($e);
            toastr()->error('Failed to create product.');
            return back();
        }


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
        try{
            DB::beginTransaction();
            $productSize = ProductSize::findOrFail($id);
            if (!$productSize) {
                toastr()->error('Product Size not found.');
                return back();
            }

            $validator = Validator::make($request->all(), [
                'product_id' => 'nullable|exists:products,id',
                'size' => 'nullable|string|max:255',
                'price' => 'nullable|numeric',
                'stock_quantity' => 'nullable|numeric',
                'status' => 'nullable|integer|in:0,1',
            ]);
            if ($validator->fails()) {
                toastr()->error($validator->errors()->first());
                return back();
            }

            $data = $validator->validated();
            $productSize->update($data);
            DB::commit();
            toastr()->success('Product Size updated successfully.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            report_error($e);
            toastr()->error('Failed to update product size.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();
            $productSize = ProductSize::findOrFail($id);
            if (!$productSize) {
                toastr()->error('Product Size not found.');
                return back();
            }
            $productSize->delete();
            DB::commit();
            toastr()->success('Product Size deleted successfully.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            report_error($e);
            toastr()->error('Failed to delete product size.');
            return back();
        }
    }
}
