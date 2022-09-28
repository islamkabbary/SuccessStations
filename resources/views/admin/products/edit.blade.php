@extends('admin.layout.base')

@section('title', trans('admin.edit-product'))

@section('content')

    <div class="row">
        <div class="col-lg-3">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"> {{ trans('admin.edit-product') }} </h4>
                    </div>
                </div>
            </div>
            <div class="iq-card">
                <div class="iq-card-body">
                    <form>
                        @if ($data->images->count() > 0)
                            @foreach ($data->images as $image)
                                <div class="form-group text-center">
                                    <div class="add-img-user profile-img-edit">
                                        <img class="profile-pic img-fluid" src="{{ $image->path }}"
                                            alt="profile-pic">
                                        <div class="p-image">
                                            <a href="#"
                                                class="upload-button btn iq-bg-primary">{{ trans('admin.image') }}</a>
                                            <input name="image[]" class="file-upload" form="edit-user-form" type="file"
                                                accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <img class="profile-pic img-fluid" src="{{ asset('assets/imgs/avatar.png') }}"
                                alt="profile-pic">
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"> {{ trans('admin.product-info') }}</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    @include('admin.include.messages_errors')
                    <div class="new-user-info">
                        {!! Form::open([
                            'method' => 'put',
                            'route' => ['products.update', $data->id],
                            'enctype' => 'multipart/form-data',
                            'id' => 'edit-user-form',
                        ]) !!}
                        <div class="row">
                            @method('PUT')
                            <div class="form-group col-md-6">
                                {!! Form::label('name', trans('admin.name')) !!}
                                <span class="asters">*</span>
                                {!! Form::text('name', old('name') ?? $data->name, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'id' => 'name',
                                    'placeholder' => trans('admin.name'),
                                ]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('price', trans('admin.price')) !!}
                                <span class="asters">*</span>
                                {!! Form::number('price', old('price') ?? $data->price, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'id' => 'price',
                                    'placeholder' => trans('admin.price'),
                                ]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('qty', trans('admin.qty')) !!}
                                <span class="asters">*</span>
                                {!! Form::text('qty', old('qty') ?? $data->qty, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'id' => 'qty',
                                    'placeholder' => trans('admin.qty'),
                                ]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('description', trans('admin.description')) !!}
                                <span class="asters">*</span>
                                {!! Form::text('description', old('description') ?? $data->description, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'id' => 'description',
                                    'placeholder' => trans('admin.description'),
                                ]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('status', trans('admin.status')) !!}
                                <span class="asters">*</span>
                                {!! Form::select(
                                    'status',
                                    [1 => trans('admin.available'), 0 => trans('admin.not_available')],
                                    old('status') ?? $data->status,
                                    ['class' => 'form-control', 'id' => 'status', 'placeholder' => trans('admin.status')],
                                ) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('brand' , trans('admin.brand')) !!}
                                <span class="asters">*</span>
                                {!! Form::select('brand_id' ,$brands ,old('brand_id') ?? $data->brand_id,['class'=>'form-control' , 'id'=>'brand_id' , 'placeholder'=>trans('admin.brand')]) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('services' , trans('admin.services')) !!}
                                <span class="asters">*</span>
                                {!! Form::select('service_id' ,$services ,old('service_id')?? $data->service_id ,['class'=>'form-control' , 'id'=>'service_id' , 'placeholder'=>trans('admin.services')]) !!}
                            </div>
                            <div class="col-md-12">
                                {!! Form::submit(trans('admin.save'), ['class' => 'btn btn-primary ml-2 pull-left']) !!}
                                {!! Form::reset(trans('admin.cancel'), ['class' => 'btn btn-secondary pull-left']) !!}
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