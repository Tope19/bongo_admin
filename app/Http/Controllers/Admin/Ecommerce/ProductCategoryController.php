<?php

namespace App\Http\Controllers\Admin\Ecommerce;


use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::latest()->get();
        return view('dashboard.ecommerce.categories.index', compact('categories'));
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
        // dd($request->all());
        try{
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'icon' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            ]);

            if ($validator->fails()) {
                toastr()->error($validator->errors()->first());
                return back();
                // return redirect()
                //     ->back()
                //     ->withErrors($validator)
                //     ->withInput(); // keeps old input values
            }

            // If passed, you can use:
            $data = $validator->validated();
            // if request has an icon, store it
            if ($request->hasFile('icon')) {
                $data['icon'] = $request->file('icon')->store('product_categories', 'public');
                // get the url of the stored icon
                $data['icon'] = asset('storage/' . $data['icon']);
            }
            $data['status'] = 1;
            ProductCategory::create($data);
            DB::commit();
            toastr()->success('Product category created successfully.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error('Failed to create product category.');
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
            // dd($request->all());
        $request->validate([
            'name' => 'required|exists:product_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
            'status' => 'required|in:0,1',
        ], [
            'name.required' => 'The name field is required.',
            'name.exists' => 'The selected name is invalid.',
            'description.string' => 'The description must be a string.',
            'icon.file' => 'The icon must be a file.',
            'icon.mimes' => 'The icon must be a file of type: jpg, jpeg, png, svg.',
            'icon.max' => 'The icon may not be greater than 2048 kilobytes.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The selected status is invalid.',
        ]);

        try {
            DB::beginTransaction();

            $category = ProductCategory::findOrFail($id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->status = $request->status;

            if ($request->hasFile('icon')) {
                // Delete old image from storage
                $oldPath = str_replace(asset('storage') . '/', '', $category->icon);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                // Store new image
                $path = $request->file('icon')->store('product_categories', 'public');
                $category->icon = asset('storage/' . $path);
            }

            $category->save();
            DB::commit();
            toastr()->success('Product category updated successfully.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            report_error($e);
            toastr()->error('Failed to update product category.');
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
            $category = ProductCategory::find($id);
            if (!$category) {
                toastr()->error('Product category not found.');
                return back();
            }

            // Convert full asset URL back to relative path for deletion
            $relativePath = str_replace(asset('storage') . '/', '', $category->icon);
            // Delete the file from storage
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
            $category->delete();
            DB::commit();
            toastr()->success('Product category deleted successfully.');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            report_error($e);
            toastr()->error('Failed to delete product category.');
            return back();
        }
    }
}
