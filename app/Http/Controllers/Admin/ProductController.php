<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Service;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all()->pluck('name', 'id');
        $services = Service::all()->pluck('name', 'id');
        return view('admin.products.insert', compact('brands', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        $data = $request->only(['name', 'price', 'qty', 'description', 'status', 'brand_id', 'service_id']);
        $data['company_id'] = Auth::user()->company->id;
        $product = Product::create($data);
        foreach ($request->file('image') as $image) {
            $newimage = FileHelper::upload_file("images/products", $image);
            $product->images()->create(['type' => 'product', 'path' => asset("storage/$newimage")]);
        }
        DB::commit();
        DB::rollBack();
        session()->flash('success', trans('admin.product-add-message'));
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::findOrFail($id);
        return view('admin.products.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::findOrFail($id);
        $brands = Brand::all()->pluck('name', 'id');
        $services = Service::all()->pluck('name', 'id');
        return view('admin.products.edit', compact('data', 'brands', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        DB::beginTransaction();
        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'price', 'qty', 'description', 'brand_id', 'service_id', ['status' => $request->status ? $request->status : $product->status]]));
        if ($request->file('image')) {
            if ($request->file('image')->count() > 1) {
                $product->images()->delete();
                foreach ($request->file('image') as $image) {
                    $newimage = FileHelper::upload_file("images/products", $image);
                    $product->images()->create(['type' => 'product', 'path' => asset("storage/$newimage")]);
                }
            } else {
                $product->images()->delete();
                $newimage = FileHelper::upload_file("images/products", $request->file('image'));
                $product->images()->create(['type' => 'product', 'path' => asset("storage/$newimage")]);
            }
        }
        DB::commit();
        DB::rollBack();
        session()->flash('success', trans('admin.product-edit-message'));
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->images->count() > 0) {
            foreach ($product->images as $image) {
                FileHelper::delete_picture($image);
            }
        } else {
            FileHelper::delete_picture($product->images);
        }
        $product->delete();
        session()->flash('success', trans('admin.product-delete-message'));
        return redirect()->route('products.index');
    }
}
