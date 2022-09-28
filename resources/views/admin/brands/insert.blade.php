@extends('admin.layout.base')

@section('title', trans('admin.add-tag'))

@section('content')
    {!! Form::open(['method'=>'post' , 'route'=>'brands.store' ,'enctype'=>'multipart/form-data'  , 'id'=>'add-user-form']) !!}
    @method('POST')
    @include('admin.brands.inputs')
    {!! Form::close() !!}

@endsection
