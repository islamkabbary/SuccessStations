<?php

namespace App\Http\Controllers\Admin;

use App\Services\BrandService;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $Service;
    public function __construct(BrandService $BrandSer)
    {
        $this->Service = $BrandSer;
    }

    public function index()
    {
        $brands = $this->Service->index();
        return view('admin.brands.index' , compact( 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.insert');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $this->Service->store($request);
        session()->flash('success' , trans('admin.add-message'));
        return redirect()->route('brands.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->Service->show($id);
        return view('admin.brands.edit' , compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $this->Service->update($id , $request);
        session()->flash('success' , trans('admin.edit-message'));
        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->Service->destroy($id);
        session()->flash('success' , trans('admin.delete-message'));
        return redirect()->route('brands.index');
    }
}
