<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Company;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $Service;
    public function __construct(CategoryService $CategorySer)
    {
        $this->Service = $CategorySer;
    }

    public function index()
    {
        $categories = $this->Service->index();
        return view('admin.categories.index' , compact( 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all()->pluck('name', 'id');
        $companies = Company::all()->pluck('name', 'id');
        return view('admin.categories.insert', compact( 'cities','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->Service->store($request);
        $category->companies()->sync($request->company_id, false);
        session()->flash('success' , trans('admin.add-message'));
        return redirect()->route('streets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $data = $this->Service->show($category->id);
        return view('admin.categories.show' , compact('data'));
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
        $cities = City::all()->pluck('name', 'id');
        $companies = Company::all()->pluck('name', 'id');
        return view('admin.categories.edit' , compact('data','cities','companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->Service->update($id , $request);
        $category->companies()->sync($request->company_id, false);
        session()->flash('success' , trans('admin.edit-message'));
        return redirect()->route('streets.index');
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
        return redirect()->route('streets.index');
    }
}
