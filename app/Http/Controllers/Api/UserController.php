<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\User;
use App\Helpers\FileHelper;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserAddressResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function updateName(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $user = Auth::user();
            $user->update([
                'name' => $request->name,
            ]);
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Name updated successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function updateImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:2048',
            ]);
            $user = Auth::user();
            if ($user->image == null) {
                $image = FileHelper::upload_file('user/profile', $request->image);
                $user->image = $image;
                $user->save();
            } else {
                $image = FileHelper::update_file('user/profile', $request->image, $user->image);
                $user->image = $image;
                $user->save();
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.update_image_message'),'data'=>$user->image], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'password' => ['required', 'confirmed', Password::min(6)],
                'old_password' => 'required',
            ]);
            if (Hash::check($request->old_password, auth()->user()->password)) {
                User::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($request->password)
                ]);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.update_password_message')], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function updatePhone(Request $request, $text = null)
    {
        try {
            $request->validate([
                'phone' => 'required|unique:users,phone,' . auth()->user()->id,
            ]);
            $user = Auth::user();
            $user->phone = $request->phone;
            $user->save();
            // $message = new SMSHelper();
            // if ($text != null) {
            //     $message->sendMessage($text . ' ' . $user->code, $user->phone);
            // } else {
            //     $message->sendMessage(trans('admin.use_code_change_password') . ' ' . $user->code, $user->phone);
            // }
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Phone updated successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function addAddress(Request $request)
    {
        try {
            $request->validate([
                'location_type' => 'required|in:home,work,others',
                'building_type' => 'required|in:villa,Building,Apartment',
                'street_name' => 'required|string',
                'building_number' => 'required|string',
                'turn_number' => 'nullable',
                'apartment_number' => 'nullable|integer',
                'location_details' => 'nullable|string',
                'is_default' => 'nullable',
                'city_id' => 'required',
            ]);
            $userAdress = new UserAddress();
            $userAdress->user_id = Auth::id();
            $userAdress->city_id = $request->city_id;
            $userAdress->location_type = $request->location_type ? $request->location_type : 'home';
            $userAdress->building_type = $request->building_type ? $request->building_type : 'Building';
            $userAdress->street_name = $request->street_name ? $request->street_name : null;
            $userAdress->building_number = $request->building_number ? $request->building_number : null;
            $userAdress->turn_number = $request->turn_number ? $request->turn_number : null;
            $userAdress->apartment_number = $request->apartment_number ? $request->apartment_number : null;
            $userAdress->location_details = $request->location_details ? $request->location_details : null;
            if ($request->is_default == 1) {
                UserAddress::where('user_id', Auth::id())->update(['is_default' => 0]);
                $userAdress->is_default = 1;
            } else {
                $userAdress->is_default = 0;
            }
            $userAdress->save();
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Address create successfully'), 'data' => new UserAddressResource($userAdress)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'code' => 400, 'data' => $th->getMessage()], 404);
        }
    }

    public function allAddress()
    {
        try {
            $userAdress = UserAddress::where('user_id', Auth::id())->get();
            return response()->json(['status' => 1, 'code' => 200, 'data' => UserAddressResource::collection($userAdress)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'code' => 400, 'data' => $th->getMessage()], 404);
        }
    }

    public function changeAddress(Request $request)
    {
        try {
            $request->validate([
                'address_id' => 'required',
                'location_type' => 'sometimes|in:home,work,others',
                'building_type' => 'sometimes|in:villa,Building,Apartment',
                'city_id' => 'nullable',
                'building_number' => 'nullable|string',
                'street_name' => 'nullable|string',
                'turn_number' => 'nullable|integer',
                'apartment_number' => 'nullable|integer',
                'location_details' => 'nullable|string',
                'is_default' => 'nullable|boolean',
            ]);
            $userAdress = UserAddress::findOrFail($request->address_id);
            $userAdress->update([
                'city_id' => $request->city_id ? $request->city_id : $userAdress->city_id,
                'location_type' => $request->location_type ? $request->location_type : $userAdress->location_type,
                'building_type' => $request->building_type ? $request->building_type : $userAdress->building_type,
                'building_number' => $request->building_number ? $request->building_number : $userAdress->building_number,
                'street_name' => $request->street_name ? $request->street_name : $userAdress->street_name,
                'turn_number' => $request->turn_number ? $request->turn_number : $userAdress->turn_number,
                'apartment_number' => $request->apartment_number ? $request->apartment_number : $userAdress->apartment_number,
                'location_details' => $request->location_details ? $request->location_details : $userAdress->location_details,
            ]);
            if ($request->is_default == 1) {
                UserAddress::where('user_id', Auth::id())->update(['is_default' => 0]);
                $userAdress->is_default = 1;
                $userAdress->save();
            } elseif ($request->is_default == 0) {
                $userAdress->is_default = 0;
                $userAdress->save();
            } else {
                $userAdress->is_default = $request->is_default;
                $userAdress->save();
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Address updated successfully') , 'data'=>new UserAddressResource($userAdress)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'code' => 400, 'data' => $th->getMessage()], 404);
        }
    }

    public function allCity()
    {
        try {
            $city = City::all();
            return response()->json(['status' => 1, 'code' => 200, 'data' => $city], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'code' => 400, 'data' => $th->getMessage()], 404);
        }
    }
}
