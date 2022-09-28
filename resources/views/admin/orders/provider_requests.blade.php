@extends('admin.layout.base')
@section('title', trans('admin.requests'))
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">
                        {{trans('admin.requests')}}
                    </h4>
                </div>
            </div>
            <div class="iq-card-body">
                @if(session()->has('success'))
                    <div class="alert text-white bg-primary" role="alert">
                        <div class="iq-alert-text">{{session()->get('success')}}</div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                        </button>
                    </div>
                @endif
                <table class="table table-striped table-bordered mt-4 table-hover text-center datatable-example" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.name')}}</th>
                        <th>{{trans('admin.phone')}}</th>
                        <th>{{trans('admin.email')}}</th>
                        <th>{{trans('admin.image')}}</th>
                        <th>{{trans('admin.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index=>$item)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->phone_without_country_code()}}</td>
                                <td>{{$item->email}}</td>
                                <td>
                                    @if($item->image != null)
                                        <img src="{{asset('storage/' . $item->image)}}" style="width:40px;height:40px;" />
                                    @else
                                        <img src="{{asset('assets/imgs/avatar.png')}}" style="width:40px;height:40px;" />
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="flex align-items-center list-user-action">
                                        <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="{{trans('admin.approve')}}" data-original-title="Approve" href="{{route('provider.approve' , $item->id)}}">
                                            <i class="fa fa-check fa-fw"></i>
                                        </a>
                                        <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="{{trans('admin.show')}}" data-original-title="Edit" href="{{route('providers.show' , $item->id)}}">
                                            <i class="ri-slideshow-3-line"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
