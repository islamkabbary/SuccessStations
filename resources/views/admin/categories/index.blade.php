@extends('admin.layout.base')
@section('title', trans('admin.Streets'))
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="iq-card">
                <a href="{{route('streets.create')}}" class="btn btn-text-primary font-weight-bold btn-fixed" data-palcement="top" data-toggle="tooltip" title="{{trans('admin.add-street')}}">
                    <i class="fa fa-plus"></i>
                </a>
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">
                            {{ trans('admin.Streets') }}
                            {{-- Streets --}}
                        </h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    @if (session()->has('success'))
                        <div class="alert text-white bg-primary" role="alert">
                            <div class="iq-alert-text">{{ session()->get('success') }}</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    @endif
                    <table class="table table-striped table-bordered mt-4 table-hover text-center datatable-example"
                        id="kt_datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.name') }}</th>
                                <th>{{ trans('admin.is_show') }}</th>
                                <th>{{ trans('admin.color') }}</th>
                                <th>{{ trans('admin.city') }}</th>
                                <th>{{ trans('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        {{ $item->is_show == 1 ? trans('admin.yes') : trans('admin.no') }}
                                    </td>
                                    <td>{{ $item->color }}</td>
                                    <td>{{ $item->city ? $item->city->name : null }}</td>
                                    <td class="text-center">
                                        <div class="flex align-items-center list-user-action">
                                            <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top"
                                                title="{{ trans('admin.edit') }}" data-original-title="Edit"
                                                href="{{ route('streets.edit', $item->id) }}">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                            <a class="iq-bg-primary" href="#" data-toggle="modal"
                                                data-target="#delmodel{{ $item->id }}">
                                                <i class="ri-delete-bin-line" data-toggle="tooltip" data-placement="top"
                                                    title="{{ trans('admin.delete') }}"></i>
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="delmodel{{ $item->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="delmodellabel{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="delmodelLabel{{ $item->id }}">
                                                                {{ __('admin.delete') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-left">
                                                                {{ __('admin.are-you-sure-to delete') }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('admin.cancel') }}</button>
                                                            {!! Form::open(['method'=>'delete' , 'route'=>['streets.destroy' ,$item->id] , 'class'=>'d-inline']) !!}
                                                            <button type="submit" class="btn btn-primary border-0" data-toggle="tooltip"
                                                                    data-placement="top" title=""
                                                                    data-original-title="{{trans('admin.delete')}}">
                                                                    {{trans('admin.delete')}}
                                                            </button>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
