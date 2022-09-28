@extends('admin.layout.base')

@section('title', trans('admin.edit-order'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"> {{trans('admin.orders-info')}}</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    @include('admin.include.messages_errors')
                    <div class="new-user-info">
                        {!! Form::open(['method'=>'put' , 'route'=>['orders.update' , $data->id] ,'enctype'=>'multipart/form-data'  , 'id'=>'edit-user-form']) !!}
                        <div class="row">
                            @method('PUT')
                            <div class="form-group col-md-6">
                                {!! Form::label('status' , trans('admin.status')) !!}
                                <span class="asters">*</span>
                                {!! Form::select('status' ,['delivery_before'=>trans('admin.delivery_before'),'prepared_time'=>trans('admin.prepared_time'),'move_time'=>trans('admin.move_time'),'arrival_time'=>trans('admin.arrival_time')] ,$data->status ?? old('status') ,['class'=>'form-control' , 'id'=>'status' , 'placeholder'=>trans('admin.status')]) !!}
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
