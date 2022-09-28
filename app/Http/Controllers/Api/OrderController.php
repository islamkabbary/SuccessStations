<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Rate;
use App\Models\Order;
use App\Models\AddedTax;
use App\Models\PromoCode;
use App\Models\UserAddress;
use App\Models\orderDetails;
use Illuminate\Http\Request;
use App\Models\DeliveryValue;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\orderDetailsResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $request->validate([
                'company_id' => 'required|exists:companies,id',
                'user_addresses_id' => 'nullable|required_if:location_type,null|exists:user_addresses,id',
            ]);
            DB::beginTransaction();
            $order = new Order;
            $order->user_id = Auth::id();
            $order->company_id = $request->company_id;
            $lastOrder = Order::orderBy('id', 'DESC')->first('order_number');
            if ($lastOrder != null && $lastOrder->order_number != null) {
                $order->order_number = $lastOrder->order_number += 1;
            } else {
                $order->order_number = 1;
            }
            if ($request->has('phone')) {
                $order->phone = $request->phone;
            }
            if ($request->has('promo_code')) {
                if ($this->checkPromoCode($request->promo_code)) {
                    $order->promo_code_id = $this->checkPromoCode($request->promo_code);
                }
            }
            if ($request->user_addresses_id == null) {
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
                $userAdress->building_type = $request->building_type ? $request->building_type : 'villa';
                $userAdress->location_type = $request->location_type ? $request->location_type : 'home';
                $userAdress->building_number = $request->building_number ? $request->building_number : null;
                $userAdress->street_name = $request->street_name ? $request->street_name : null;
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
                $order->user_addresses_id = $userAdress->id;
            } else {
                $order->user_addresses_id = $request->user_addresses_id;
            }
            $products = Auth::user()->products->where('company_id', $request->company_id);
            if ($products->count() == 0) {
                return response()->json(['status' => 0, 'message' => trans('admin.No products in cart')], 404);
            }
            foreach ($products as $product) {
                if ($product->pivot->qty > $product->qty) {
                    return response()->json(['status' => 0, 'message' => trans('admin.Not enough products in stock'), 'qty' => $product->qty], 404);
                }
                $order->sub_total += $product->price * $product->pivot->qty;
            }
            $tax = AddedTax::where('company_id', $request->company_id)->first();
            $DeliveryValue = DeliveryValue::where('company_id', $request->company_id)->first();
            if ($tax) {
                $order->added_tax_id = $tax->id;
                $order->total = $order->sub_total + ($order->sub_total * $tax->tax / 100);
            }
            if ($DeliveryValue) {
                $order->delivery_value_id = $DeliveryValue->id;
                $order->total = $order->total + $DeliveryValue->delivery_value;
            }
            $order->save();
            foreach ($products as $product) {
                $orderDetail = new orderDetails;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product->id;
                $orderDetail->qty = $product->pivot->qty;
                $orderDetail->price = $product->price;
                $orderDetail->total = $product->price * $orderDetail->qty;
                $orderDetail->save();
                $product->update(['qty' => $product->qty - $product->pivot->qty]);
            }
            $data['order'] = OrderResource::make($order);
            $data['order_detail'] = $orderDetail;
            Auth::user()->products()->detach($products->pluck('id'));
            DB::commit();
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Order_created_successfully'), 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function checkPromoCode($code)
    {
        $promoCode = PromoCode::where('code', $code)->first();
        if ($promoCode != null) {
            if ($promoCode->start_date <= now()  && $promoCode->end_date >= now()) {
                if ($promoCode->limit_for_user != null) {
                    $orderForUserCount = $promoCode->orders()->where('user_id', Auth::id())->count();
                    if ($orderForUserCount >= $promoCode->limit_for_user) {
                        return false;
                    }
                }
                if ($promoCode->limit_use != null) {
                    $orderCount = $promoCode->orders()->count();
                    if ($orderCount >= $promoCode->limit_use) {
                        return false;
                    }
                }
                return $promoCode->id;
            }
        }
        return false;
    }

    public function currentOrders()
    {
        try {
            $orders = Order::where('user_id', Auth::id())->whereIn('status', ['new', 'in_way', 'prepared', 'accept'])->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Current Orders'), 'data' => OrderResource::collection($orders)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => $th->getMessage()], 404);
        }
    }

    public function lastOrders()
    {
        try {
            $orders = Order::where('user_id', Auth::id())->whereIn('status', ['reject', 'canceled', 'done'])->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Last Orders'), 'data' => OrderResource::collection($orders)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => $th->getMessage()], 404);
        }
    }

    public function cancelOrder(Request $request)
    {
        try {
            $data = Order::where('id',$request->order_id)->whereIn('status', ['new', 'prepared'])->update(['status' => 'canceled']);
            if ($data) {
                return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Order canceled successfully')], Response::HTTP_OK);
            } else {
                return response()->json(['status' => 0, 'code' => 400, 'message' => trans('admin.Order can not be canceled')], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => $th->getMessage()], 404);
        }
    }

    public function orderDetails(Request $request)
    {
        try {
            $order = Order::findOrFail($request->order_id);
            if ($order->status == 'done') {
                $data['order'] = OrderResource::make($order);
                $data['address'] = UserAddress::findOrFail($order->user_addresses_id);
                $data['products'] = orderDetailsResource::collection($order->orderDetails);
                if ($order->rate) {
                    $data['rate'] = $order->rate;
                } else {
                    $data['rate'] = null;
                }
            } else {
                $data['order'] = OrderResource::make($order);
                $data['date_start_order'] = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('D d M Y');
                $data['delivery_before'] = $order->delivery_before ? Carbon::createFromFormat('H:i:s', $order->delivery_before)->format('h:i a') : null;
                $data['start_order'] = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('h:i a');
                $data['prepared_order'] = $order->prepared_time ? Carbon::createFromFormat('H:i:s', $order->prepared_time)->format('h:i a') : null;
                $data['in_way_order'] = $order->move_time ? Carbon::createFromFormat('H:i:s', $order->move_time)->format('h:i a') : null;
                $data['address'] = UserAddress::findOrFail($order->user_addresses_id);
                $data['products'] = orderDetailsResource::collection($order->orderDetails);
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Order Details'), 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => $th->getMessage()], 404);
        }
    }

    public function rateOrder(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id',
                'rate' => 'required|numeric|between:1,5',
            ]);
            $order = Order::findOrFail($request->order_id);
            if ($order->status == 'done') {
                if ($order->rate) {
                    return response()->json(['status' => 0, 'code' => 400, 'message' => 'You have already rated this order'], 400);
                }
                Rate::create(['rate' => $request->rate, 'user_id' => Auth::id(), 'order_id' => $request->order_id]);
                return response()->json(['status' => 1, 'code' => 200, 'message' => 'Order rated successfully'], Response::HTTP_OK);
            } else {
                return response()->json(['status' => 0, 'code' => 400, 'message' => trans('admin.You can not rate this order')], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'code' => 400, 'message' => $th->getMessage()], 404);
        }
    }

    public function reOrder(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id',
            ]);
            $order = Order::findOrFail($request->order_id);
            $orderDetails = OrderDetails::where('order_id', $request->order_id)->get();
            $order->status = 'new';
            $order->promo_code_id = null;
            $order->delivery_before = null;
            $order->prepared_time = null;
            $order->move_time = null;
            $order->arrival_time = null;
            $order->rate = null;
            $newOrder = Order::create($order->toArray());
            $data['order'] = $newOrder;
            $data['address'] = UserAddress::findOrFail($newOrder->user_addresses_id);
            foreach ($orderDetails as $orderDetail) {
                $newOrderDetails = new OrderDetails;
                $newOrderDetails->order_id = $newOrder->id;
                $newOrderDetails->product_id = $orderDetail->product_id;
                $newOrderDetails->qty = $orderDetail->qty;
                $newOrderDetails->price = $orderDetail->price;
                $newOrderDetails->total = $orderDetail->total;
                $newOrderDetails->save();
            }
            $data['products'] = $newOrder->orderDetails;
            return response()->json(['status' => 1, 'code' => 200, 'message' => trans('admin.Re Order'), 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'code' => 400, 'message' => $th->getMessage()], 404);
        }
    }
}
