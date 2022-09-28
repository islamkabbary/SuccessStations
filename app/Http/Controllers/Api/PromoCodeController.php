<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromoCodeResource;
use App\Models\PromoCode;

class PromoCodeController extends Controller
{
    public function allCode()
    {
        try {
            $promo_codes = PromoCode::get();
            $data = $promo_codes->map(function ($promo_code) {
                $promo_code->company = $promo_code->company()->get();
                return $promo_code;
            });
            return response()->json(['status' => true, 'data' => PromoCodeResource::Collection($data)]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function allCodeByCity($id)
    {
        try {
            $data = PromoCode::with('company')->where('city_id', $id)->get();
            return response()->json(['status' => true, 'code' => 1, 'data' => PromoCodeResource::Collection($data)]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'code' => 0, 'message' => $e->getMessage()]);
        }
    }
}
