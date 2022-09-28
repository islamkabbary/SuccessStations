<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\CategoryResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request)
    {
        try {
            if ($request->city_id) {
                $data = Category::where('city_id', $request->city_id)->get();
                return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.categories'), 'data' => CategoryResource::collection($data)], Response::HTTP_OK);
            } else {
                $data =  Category::all();
                return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.categories'), 'data' => CategoryResource::collection($data)], Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function allCategorieswithFourProduct()
    {
        try {
            $categories = Category::get();
            $data = $categories->map(function ($category) {
                $category->products = $category->products()->take(4)->get();
                return $category;
            });
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Product In Categories'), 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function allServiceInCompanies($id)
    {
        try {
            $data = Company::find($id)->servies;
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Service In Company'), 'data' => ServiceResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }
}
