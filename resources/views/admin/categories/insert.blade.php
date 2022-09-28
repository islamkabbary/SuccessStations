@extends('admin.layout.base')

@section('title', trans('admin.add-category'))

@section('content')
    {!! Form::open(['method'=>'post' , 'route'=>'streets.store' ,'enctype'=>'multipart/form-data'  , 'id'=>'add-user-form']) !!}
    @method('POST')
    @include('admin.categories.inputs')
    {!! Form::close() !!}
@endsection
