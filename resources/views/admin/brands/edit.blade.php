@extends('admin.layout.base')

@section('title', trans('admin.edit-brands'))

@section('content')
    {!! Form::open(['method'=>'put' , 'route'=>['brands.update' , $data->id] ,'enctype'=>'multipart/form-data'  , 'id'=>'edit-user-form']) !!}
        @method('PUT')
        @include('admin.brands.inputs')
    {!! Form::close() !!}
@endsection
