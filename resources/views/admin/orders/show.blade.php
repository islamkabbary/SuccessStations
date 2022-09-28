@extends('admin.layout.base')

@section('title', 'Order Details')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="about-info m-0 p-0">
                        <div class="row">
                            <div class="col-5">{{ trans('admin.name') }}:</div>
                            <div class="col-7">{{ $order->user->name }}</div>
                            <div class="col-5">{{ trans('admin.phone') }}:</div>
                            <div class="col-7">{{ $order->user->phone }}</div>
                            <div class="col-5">{{ trans('admin.anather_phone') }}:</div>
                            <div class="col-7">{{ $order->phone }}</div>
                            <div class="col-5">{{ trans('admin.location_type') }}:</div>
                            <div class="col-7">{{ $order->UserAddresses->location_type }}</div>
                            <div class="col-5">{{ trans('admin.building_type') }}:</div>
                            <div class="col-7">{{ $order->UserAddresses->building_type }}</div>
                            <div class="col-5">{{ trans('admin.street name') }}:</div>
                            <div class="col-7">{{ $order->UserAddresses->street_name }}</div>
                            <div class="col-5">{{ trans('admin.building_number') }}:</div>
                            <div class="col-7">{{ $order->UserAddresses->building_number }}</div>
                            <div class="col-5">{{ trans('admin.apartment_number') }}:</div>
                            <div class="col-7">{{ $order->UserAddresses->apartment_number }}</div>
                            <div class="col-7">{{ trans('admin.location_details') }}:</div>
                            <div class="col-5">{{ $order->UserAddresses->location_details }}</div>
                            <div class="col-7">{{ trans('admin.tax') }}:</div>
                            <div class="col-5">{{ $order->tax }}</div>
                            <div class="col-7">{{ trans('admin.delivery_value') }}:</div>
                            <div class="col-5">{{ $order->delivery_value }}</div>
                            <div class="col-5">{{ trans('admin.total') }}:</div>
                            <div class="col-7">{{ $order->total }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($data as $item)
            <div class="col-lg-4">
                <div class="iq-card">
                    <div class="iq-card-body">
                        @if (!empty($item->product->images))
                            <img class="profile-pic img-fluid" style="max-height: 150px" src="{{ $item->product->images->pop()->path }}"
                                alt="profile-pic">
                        @else
                            <img class="profile-pic img-fluid" src="{{ asset('assets/imgs/avatar.png') }}"
                                alt="profile-pic">
                        @endif
                    </div>
                </div>
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="about-info m-0 p-0">
                            <div class="row">
                                @if (!empty($item->product_id))
                                    <div class="col-5">{{ trans('admin.product name') }}:</div>
                                    <div class="col-7">{{ $item->product->name }}</div>
                                @endif
                                @if (!empty($item->qty))
                                    <div class="col-5">{{ trans('admin.qty') }}:</div>
                                    <div class="col-7">{{ $item->qty }}</div>
                                @endif
                                @if (!empty($item->price))
                                    <div class="col-5">{{ trans('admin.price') }}:</div>
                                    <div class="col-7">{{ $item->price }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
