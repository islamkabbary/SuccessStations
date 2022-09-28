@extends('admin.layout.base')

@section('title', $data->name)

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="iq-card">
                <div class="iq-card-body">
                    @if (!empty($data->images))
                        <img class="profile-pic img-fluid" src="{{ $data->images->pop()->path }}" alt="profile-pic">
                    @else
                        <img class="profile-pic img-fluid" src="{{ asset('assets/imgs/avatar.png') }}" alt="profile-pic">
                    @endif
                </div>
            </div>
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="about-info m-0 p-0">
                        <div class="row">
                            @if (!empty($data->name))
                                <div class="col-5">{{ trans('admin.name') }}:</div>
                                <div class="col-7">{{ $data->name }}</div>
                            @endif
                            @if (!empty($data->mobile))
                                <div class="col-5">{{ trans('admin.phone') }}:</div>
                                <div class="col-7">{{ $data->mobile }}</div>
                            @endif
                            @if (!empty($data->owner_id))
                                <div class="col-5">{{ trans('admin.owner') }}:</div>
                                <div class="col-7">{{ $data->user->name }}</div>
                            @endif
                            @if (!empty($data->address))
                                <div class="col-3">{{ trans('admin.address') }}:</div>
                                <div class="col-9">{{ $data->address }}</div>
                            @endif
                            @if (!empty($data->number_company))
                                <div class="col-5">{{ trans('admin.number_company') }}:</div>
                                <div class="col-7">{{ $data->number_company }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
