@extends('admin.layout.base')

@section('title', trans('admin.edit-city'))

@section('content')
    {!! Form::open(['method'=>'put' , 'route'=>['cities.update' , $data->id] ,'enctype'=>'multipart/form-data'  , 'id'=>'edit-user-form']) !!}
        @method('PUT')
        @include('admin.cities.inputs')
    {!! Form::close() !!}
@endsection
