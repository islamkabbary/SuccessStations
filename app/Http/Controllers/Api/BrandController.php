<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class BrandController extends Controller
{
    public function allBrandInServices(Request $request)
    {
        try {
            $servieses = Company::findOrFail($request->company_id)->servies;
            $serv = $servieses->where('id', $request->service_id)->first();
            foreach ($serv->brands as $brand) {
                $data[] = $brand;
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans(''), 'data' => BrandResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }
}
