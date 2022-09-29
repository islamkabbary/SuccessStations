<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ads;
use App\Services\AdsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdsRequest;
use App\Models\Country;
use App\Models\Service;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $Service;
    public function __construct(AdsService $adsSer)
    {
        $this->Service = $adsSer;
    }

    public function index()
    {
        $ads = $this->Service->index();
        return view('admin.ads.index' , compact( 'ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all()->pluck('name', 'id');
        $services = Service::all()->pluck('name', 'id');
        return view('admin.ads.insert', compact('countries','services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdsRequest $request)
    {
        $Ads = $this->Service->store($request);
        if(session()->has('failed')){
            return redirect()->back();
        }
        $Ads->countries()->attach($request->country_id);
        $Ads->services()->attach($request->service_id);
        session()->flash('success' , trans('admin.add-message'));
        return redirect()->route('ads.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ads $Ads)
    {
        $data = $this->Service->show($Ads->id);
        return view('admin.ads.show' , compact('data'));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $data = $this->Service->show($id);
    //     // $cities = City::all()->pluck('name', 'id');
    //     // $companies = Company::all()->pluck('name', 'id');
    //     return view('admin.ads.edit' , compact('data','cities','companies'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(AdsRequest $request, $id)
    // {
    //     $Ads = $this->Service->update($id , $request);
    //     $Ads->companies()->sync($request->company_id, false);
    //     session()->flash('success' , trans('admin.edit-message'));
    //     return redirect()->route('streets.index');
    // }

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
        return redirect()->route('ads.index');
    }
}
