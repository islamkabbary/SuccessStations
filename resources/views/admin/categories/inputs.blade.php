<div class="row">
    <div class="col-lg-3">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">
                        @if(isset($data))
                        {{trans('admin.edit-Street')}}
                        @else
                        {{trans('admin.add-Street')}}
                        @endif
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title"> {{trans('admin.Street-info')}}</h4>
                </div>
            </div>
            <div class="iq-card-body">
                @include('admin.include.messages_errors')
                <div class="new-user-info">
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('name_ar' , trans('admin.name_ar')) !!}
                            <span class="asters">*</span>
                            {!! Form::text('name_ar' , $data->name_ar ?? old('name_ar') ,['class'=>'form-control' , 'id'=>'name_ar' , 'placeholder'=>trans('admin.name_ar')]) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('name_en' , trans('admin.name_en')) !!}
                            <span class="asters">*</span>
                            {!! Form::text('name_en' , $data->name_en ?? old('name_en') ,['class'=>'form-control' , 'id'=>'name_en' , 'placeholder'=>trans('admin.name_en')]) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('is_show' , trans('admin.is_show')) !!}
                            <span class="asters">*</span>
                            {!! Form::select('is_show' ,[1=>trans('admin.yes') ,0=>trans('admin.no')] ,$data->is_show ?? old('is_show') ,['class'=>'form-control' , 'id'=>'is_show' , 'placeholder'=>trans('admin.is_show')]) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('color' , trans('admin.color')) !!}
                            <span class="asters">*</span>
                            {!! Form::color('color' , $data->color ?? old('color') ,['class'=>'form-control' , 'id'=>'color']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('city' , trans('admin.city')) !!}
                            <span class="asters">*</span>
                            {!! Form::select('city_id' ,$cities , $data->city_id ?? old('city_id')  ,['class'=>'form-control' , 'id'=>'city_id' , 'placeholder'=>trans('admin.city')]) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('companies' , trans('admin.companies')) !!}
                            <span class="asters">*</span>
                            {!! Form::select('company_id[]' ,$companies , $data->company_id ?? old('company_id'),['class'=>'form-control' , 'id'=>'company_id', 'multiple' , 'placeholder'=>trans('admin.companies')]) !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::submit(trans('admin.save') , ['class'=>'btn btn-primary ml-2 pull-left']) !!}
                            {!! Form::reset(trans('admin.cancel') , ['class'=>'btn btn-secondary pull-left']) !!}
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
