@extends('admin.layout.base')

@section('title', trans('admin.add-market'))

@section('content')

    <div class="row">
        <div class="col-lg-3">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"> {{trans('admin.add-market')}} </h4>
                    </div>
                </div>
            </div>
            <div class="iq-card">
                <div class="iq-card-body">
                    <form>
                        <div class="form-group text-center">
                            <div class="add-img-user profile-img-edit">
                                <img class="profile-pic img-fluid"
                                    src="{{ asset('assets/imgs/avatar.png') }}" alt="profile-pic">
                                <div class="p-image">
                                    <a href="#" class="upload-button btn iq-bg-primary">{{trans('admin.image')}}</a>
                                    <input name="image" class="file-upload"  form="add-user-form" type="file" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"> {{trans('admin.market-info')}}</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    @include('admin.include.messages_errors')
                    <div class="new-user-info">
                        {!! Form::open(['method'=>'post' , 'route'=>'markets.store' ,'enctype'=>'multipart/form-data'  , 'id'=>'add-user-form']) !!}
                        <div class="row">   
                            @method('POST')
                            <div class="form-group col-md-6">
                                {!! Form::label('name' , trans('admin.name')) !!}
                                <span class="asters">*</span>
                                {!! Form::text('name' , old('name') ,['class'=>'form-control' ,'required'=>'required', 'id'=>'name' , 'placeholder'=>trans('admin.name')]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('owner' , trans('admin.owner')) !!}
                                <span class="asters">*</span>
                                {!! Form::select('owner_id' ,$users ,old('owner') ,['class'=>'form-control' , 'id'=>'owner' , 'placeholder'=>trans('admin.owner')]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('mobile' , trans('admin.phone')) !!}
                                <span class="asters">*</span>
                                {!! Form::text('mobile' , old('mobile') ,['class'=>'form-control' ,'required'=>'required', 'id'=>'mobile' , 'placeholder'=>trans('admin.phone')]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('address' , trans('admin.address')) !!}
                                <span class="asters">*</span>
                                {!! Form::text('address' , old('address') ,['class'=>'form-control' ,'required'=>'required', 'id'=>'address' , 'placeholder'=>trans('admin.address')]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('number_company' , trans('admin.number_company')) !!}
                                <span class="asters">*</span>
                                {!! Form::number('number_company' , old('number_company') ,['class'=>'form-control' ,'required'=>'required', 'id'=>'number_company' , 'placeholder'=>trans('admin.number_company')]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('service' , trans('admin.service')) !!}
                                <span class="asters">*</span>
                                {!! Form::select('service_id[]' ,$service , $data->service_id ?? old('service_id'),['class'=>'form-control' , 'id'=>'service_id', 'multiple' , 'placeholder'=>trans('admin.service')]) !!}
                            </div>
                            <div class="col-md-12">
                                {!! Form::submit(trans('admin.save') , ['class'=>'btn btn-primary ml-2 pull-left']) !!}
                                {!! Form::reset(trans('admin.cancel') , ['class'=>'btn btn-secondary pull-left']) !!}
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
