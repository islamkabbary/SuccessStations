<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Country;
use App\Services\SettingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;

class SettingController extends Controller
{
    protected $SettingService;
    public function __construct(SettingService $SettingSer)
    {
        $this->SettingService = $SettingSer;
    }
    public function settings()
    {
        $country = Country::all()->pluck('name', 'id');
        return view('admin.settings.settings',compact('country'));
    }

    public function update(SettingRequest $request)
    {
        $this->SettingService->store($request);
        session()->flash('success', trans('admin.setting-edit-message'));
        return redirect()->back();
    }

    public function getPrivacy()
    {
        $data = $this->SettingService->getSettingData('policy', app()->getLocale());
        return view('admin.settings.privacy', compact('data'));
    }

    public function getTerms()
    {
        $data = $this->SettingService->getSettingData('terms', app()->getLocale());
        return view('admin.settings.terms', compact('data'));
    }

    public function changeLang($lang)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->lang = $lang;
        $user->save();
        return redirect()->back();
    }
}
