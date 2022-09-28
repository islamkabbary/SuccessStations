@extends('admin.layout.base')

@section('title', $data->name)

@section('content')
    <div class="row">
        @if ($data->images->count() > 0)
            @foreach ($data->images as $image)
                <div class="col-lg-3">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <img class="profile-pic img-fluid" src="{{ $image->path }}" style="height:250px;width:250px;"
                                alt="profile-pic">
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="col-lg-5">
        <div class="iq-card">
            <div class="iq-card-body">
                <div class="about-info m-0 p-0">
                    <div class="row">
                        @if (!empty($data->name))
                            <div class="col-5">{{ trans('admin.name') }}:</div>
                            <div class="col-7">{{ $data->name }}</div>
                        @endif
                        @if (!empty($data->price))
                            <div class="col-5">{{ trans('admin.price') }}:</div>
                            <div class="col-7">{{ $data->price }}</div>
                        @endif
                        @if (!empty($data->qty))
                            <div class="col-5">{{ trans('admin.qty') }}:</div>
                            <div class="col-7">{{ $data->qty }}</div>
                        @endif
                        @if (!empty($data->description))
                            <div class="col-3">{{ trans('admin.description') }}:</div>
                            <div class="col-9">{{ $data->description }}</div>
                        @endif
                        @if (!empty($data->status))
                            <div class="col-5">{{ trans('admin.status') }}:</div>
                            <div class="col-7">{{ $data->status }}</div>
                        @endif
                        @if (!empty($data->company))
                            <div class="col-5">{{ trans('admin.company') }}:</div>
                            <div class="col-7">{{ $data->company->name }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
