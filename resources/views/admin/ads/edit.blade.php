@extends('admin.layout.base')

@section('title', trans('admin.edit-category'))

@section('content')
    {!! Form::open(['method'=>'put' , 'route'=>['streets.update' , $data->id] ,'enctype'=>'multipart/form-data'  , 'id'=>'edit-user-form']) !!}
        @method('PUT')
        @include('admin.categories.inputs')
    {!! Form::close() !!}
@endsection
