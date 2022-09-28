<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Company;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;

class MarketController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('admin.market.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('type', 'company')->pluck('name', 'id');
        return view('admin.market.insert', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $company = Company::create($request->only(['name', 'owner_id', 'mobile', 'address', 'number_company','email', 'web_site']));
        $image = FileHelper::upload_file("images/companies", $request->file('image'));
        $company->images()->create(['type' => 'company', 'path' => asset("storage/$image")]);
        session()->flash('success', trans('admin.add-message'));
        return redirect()->route('markets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Company::findOrFail($id);
        return view('admin.market.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Company::findOrFail($id);
        $users = User::where('type', 'company')->pluck('name', 'id');
        return view('admin.market.edit', compact('data', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        Company::where('id', $id)->update($request->only(['name', 'owner_id', 'mobile', 'address', 'number_company','email', 'web_site']));
        $company = Company::findOrFail($id);
        if ($request->hasFile('image') && $company->images->count() == 0) {
            $image = FileHelper::upload_file("images/companies", $request->file('image'));
            $company->images()->create(['path' => asset("storage./$image")]);
        } elseif ($request->hasFile('image') && $company->images->count() > 0) {
            $image = FileHelper::update_file("images/companies", $request->file('image'), $company->images->first()->path);
            $company->images()->update(['path' => asset("storage/$image")]);
        }
        session()->flash('success', trans('admin.edit-message'));
        return redirect()->route('markets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        if ($company->images->count() > 0) {
            FileHelper::delete_picture($company->images[0]);
        }
        $company->delete();
        session()->flash('success', trans('admin.user-delete-message'));
        return redirect()->route('markets.index');
    }
}
