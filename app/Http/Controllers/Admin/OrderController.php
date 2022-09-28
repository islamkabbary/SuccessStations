<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Company;
use App\Models\Service;
use App\Helpers\FileHelper;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use PDF;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::findOrFail($id)->orderDetails;
        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('data', 'order'));
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
        $service = Service::all()->pluck('name', 'id');
        return view('admin.orders.edit', compact('data', 'users', 'service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($request->status == 'delivery_before') {
            $order->delivery_before = now();
            $order->status = 'new';
        } elseif ($request->status == 'prepared_time') {
            $order->prepared_time = now();
            $order->status = 'prepared';
        } elseif ($request->status == 'move_time') {
            $order->move_time = now();
            $order->status = 'in_way';
        } elseif ($request->status == 'arrival_time') {
            $order->arrival_time = now();
            $order->status = 'done';
        }
        $order->save();
        session()->flash('success', trans('admin.edit-message'));
        return redirect()->route('orders.index');
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

    public function pdf($id)
    {
        $order = Order::findOrFail($id);
        $data['order_number'] = $order->order_number;
        $data['company_image'] = $order->company->images[0]->path;
        $data['company_name'] = $order->company->name;
        $data['company_number'] = $order->company->number_company;
        $data['company_phone'] = $order->company->mobile;

        $data['customer_name'] = $order->user->name;
        $data['customer_phone'] = $order->user->phone;
        $data['customer_address'] = $order->UserAddresses->Address;
        $data["paiement_when_recieving"] = 'Paiement when recieving';
        $items = [];
        foreach ($order->orderDetails()->get() as $item) {
            $items[] = [
                'product_name' => $item->product->name,
                'qty' => $item->qty,
                'price' => $item->price,
            ];
        }
        $data['items'] = $items;
        // $pdf = \PDF::loadView('admin.pdf.document', $data);
        // return $pdf->stream('islam.pdf');
        return view('admin.pdf.document', $data);
    }
}
