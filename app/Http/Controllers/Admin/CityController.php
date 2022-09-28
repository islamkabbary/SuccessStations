<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Services\CityService;
use App\Services\CountryService;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $Service;
    public function __construct(CityService $CitySer)
    {
        $this->Service = $CitySer;
    }

    public function index()
    {
        $cities = $this->Service->index();
        return view('admin.cities.index' , compact( 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cities.insert');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $this->Service->store($request);
        session()->flash('success' , trans('admin.add-message'));
        return redirect()->route('cities.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $data = $this->Service->show($city->id);
        return view('admin.cities.edit' , compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, City $city)
    {
        $this->Service->update($city->id , $request);
        session()->flash('success' , trans('admin.edit-message'));
        return redirect()->route('cities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $this->Service->destroy($city->id);
        session()->flash('success' , trans('admin.delete-message'));
        return redirect()->route('cities.index');
    }
}
