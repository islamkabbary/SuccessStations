<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Company;
use App\Models\Product;
use App\Models\AddedTax;
use Illuminate\Http\Request;
use App\Models\DeliveryValue;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserAddressResource;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function getCart()
    {
        try {
            $data = Cart::where('user_id', Auth::id())->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Product In Cart', 'data' => CartResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'qty' => 'integer',
            ]);
            $productInCart = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
            if ($productInCart) {
                $productInCart->qty += ($request->qty ? $request->qty : 1);
                $productInCart->save();
            } else {
                $cart = new Cart();
                $cart->user_id = Auth::id();
                $cart->product_id = $request->product_id;
                $cart->qty = ($request->qty ? $request->qty : 1);
                $cart->save();
            }
            $data = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Product added to cart successfully', 'data' => CartResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function removeProductInCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'qty' => 'integer',
            ]);
            $productInCart = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
            if ($productInCart && $productInCart->qty <= 1) {
                $productInCart->delete();
            } else {
                $productInCart->qty -= ($request->qty ? $request->qty : 1);
                $productInCart->save();
            }
            $data = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Product deleted from cart successfully', 'data' => CartResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function removeItemInCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
            ]);
            $productInCart = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
            if ($productInCart) {
                $productInCart->delete();
            }
            $data = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Product deleted from cart successfully', 'data' => CartResource::collection($data)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function companiesInCart()
    {
        try {
            $data = Cart::where('user_id', Auth::id())->get()->pluck('product_id');
            $products = Product::whereIn('id', $data)->get()->pluck('company_id');
            $companies = Company::whereIn('id', $products)->get();
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Companies In Cart', 'data' => CompanyResource::collection($companies)], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage()], 404);
        }
    }

    public function productsCompanyInCart(Request $request)
    {
        try {
            $request->validate([
                'company_id' => 'required|integer|exists:companies,id',
            ]);
            $proInCompany = Auth::user()->products->where('company_id', $request->company_id);
            if ($proInCompany->count() == 0) {
                return response()->json(['status' => 0, 'code' => 404, 'message' => 'No products in this company'], 404);
            }
            $subtotal = 0;
            $total = 0;
            $products = [];
            foreach ($proInCompany as $pro) {
                $subtotal += $pro->price * $pro->pivot->qty;
                array_push($products, $pro);
            }
            $data['products'] = $products;
            $data['subtotal'] = $subtotal;
            $tax = AddedTax::where('company_id', $request->company_id)->first();
            $DeliveryValue = DeliveryValue::where('company_id', $request->company_id)->first();
            if ($tax) {
                $data['tax'] = $tax->tax;
                $total = $subtotal + ($subtotal * $tax->tax / 100);
            }
            if ($DeliveryValue) {
                $data['DeliveryValue'] = $DeliveryValue->delivery_value;
                $total = $total + $DeliveryValue->delivery_value;
            }
            $data['total'] = $total;
            $data['name_user'] = Auth::user()->name;
            $data['phone_user'] = Auth::user()->phone;
            if ($request->user_addresses_id == null) {
                if (Auth::user()->adresses->count() > 0) {
                    $address = Auth::user()->adresses->where('is_default', 1)->first();
                    if ($address) {
                        $data['address'] = UserAddressResource::make($address);
                    } else {
                        $data['address'] = UserAddressResource::make(Auth::user()->adresses->first());
                    }
                } else {
                    $data['address'] = null;
                }
            } else {
                $request->validate([
                    'user_addresses_id' => 'required|integer|exists:user_addresses,id',
                ]);
                $data['address'] = UserAddressResource::make(Auth::user()->adresses->find($request->user_addresses_id));
            }
            return response()->json(['status' => 1, 'code' => 200, 'message' => 'Products In Cart', 'data' => $data], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'data' => $th->getMessage() . $th->getLine() .$th->getFile()], 404);
        }
    }
}
