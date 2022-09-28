<?php

namespace App\Http\Controllers\Admin;

use App\Models\PromoCode;
use App\Services\PromoCodeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromoCodeRequest;
use App\Models\Company;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $Service;
    public function __construct(PromoCodeService $PromoCodeSer)
    {
        $this->Service = $PromoCodeSer;
    }

    public function index()
    {
        $promo_codes = $this->Service->index();
        return view('admin.promo_codes.index' , compact( 'promo_codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all()->pluck('name', 'id');
        return view('admin.promo_codes.insert', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromoCodeRequest $request)
    {
        $this->Service->store($request);
        session()->flash('success' , trans('admin.add-message'));
        return redirect()->route('promo_codes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PromoCode $promo_code)
    {
        $data = $this->Service->show($promo_code->id);
        return view('admin.promo_codes.show' , compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PromoCode $promo_code)
    {
        $companies = Company::all()->pluck('name', 'id');
        $data = $this->Service->show($promo_code->id);
        return view('admin.promo_codes.edit' , compact('data','companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PromoCodeRequest $request, PromoCode $promo_code)
    {
        $this->Service->update($promo_code->id , $request);
        session()->flash('success' , trans('admin.edit-message'));
        return redirect()->route('promo_codes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PromoCode $promo_code)
    {
        $this->Service->destroy($promo_code->id);
        session()->flash('success' , trans('admin.delete-message'));
        return redirect()->route('promo_codes.index');
    }
}
