<div class="row">
    <div class="col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title"> {{trans('admin.promo_code-info')}}</h4>
                </div>
            </div>
            <div class="iq-card-body">
                @include('admin.include.messages_errors')
                <div class="new-user-info">
                    <div class="row">

                        <div class="form-group col-md-6">
                            {!! Form::label('code' , trans('admin.code')) !!}
                            <span class="asters">*</span>
                            {!! Form::text('code' ,$data->code ?? old('code') ,['class'=>'form-control' , 'id'=>'code' , 'placeholder'=>trans('admin.code')]) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('company' , trans('admin.company')) !!}
                            <span class="asters">*</span>
                            {!! Form::select('company_id' ,$companies ,old('company') ,['class'=>'form-control' , 'id'=>'company' , 'placeholder'=>trans('admin.company')]) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('type' , trans('admin.type')) !!}
                            <span class="asters">*</span>
                            {!! Form::select('type' ,['percentage'=>trans('admin.percentage') , 'fixed'=>trans('admin.amount_v')],$data->type ?? old('type') ,['class'=>'form-control' , 'id'=>'type' , 'placeholder'=>trans('admin.type')]) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('discount' , trans('admin.discount')) !!}
                            <span class="asters">*</span>
                            {!! Form::text('discount' ,$data->discount ?? old('discount') ,['class'=>'form-control', 'id'=>'discount' , 'placeholder'=>trans('admin.discount')]) !!}
                            @if(isset($data))
                            {!! Form::hidden('id', $data->id) !!}
                            @endif
                        </div>


                        @if(isset($data) && $data->type == 'percentage')
                        <div class="form-group col-md-6" id="max_discount_c">
                            {!! Form::label('max_discount' , trans('admin.max_discount') ) !!}
                            {!! Form::text('max_discount' ,$data->max_discount ?? old('max_discount') ,['class'=>'form-control', 'id'=>'max_discount' , 'placeholder'=>trans('admin.max_discount')]) !!}
                        </div>
                        @else
                        <div class="form-group col-md-6" id="max_discount_c">
                            {!! Form::label('max_discount' , trans('admin.max_discount') , ['class'=>'d-none']) !!}
                            {!! Form::text('max_discount' ,$data->max_discount ?? old('max_discount') ,['class'=>'form-control d-none', 'id'=>'max_discount' , 'readonly'=>'readonly' , 'placeholder'=>trans('admin.max_discount')]) !!}
                        </div>
                        @endif

                        <div class="form-group col-md-6">
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('start_date' , trans('admin.start_date')) !!}
                            <span class="asters">*</span>
                            {!! Form::date('start_date' ,$data->start_date ?? old('start_date') ,['class'=>'form-control' , 'id'=>'start_date' , 'placeholder'=>trans('admin.start_date')]) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('end_date' , trans('admin.end_date')) !!}
                            <span class="asters">*</span>
                            {!! Form::date('end_date' ,$data->end_date ?? old('end_date') ,['class'=>'form-control' , 'id'=>'end_date' , 'placeholder'=>trans('admin.end_date')]) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('max_use' , trans('admin.max_use')) !!}
                            {!! Form::text('limit_use' ,$data->limit_use ?? old('limit_use') ,['class'=>'form-control' , 'id'=>'max_use' , 'placeholder'=>trans('admin.max_use')]) !!}
                        </div>

                        <div class="form-group col-md-6">
                            {!! Form::label('max_user_use' , trans('admin.max_user_use')) !!}
                            {!! Form::text('limit_for_user' ,$data->limit_for_user ?? old('limit_for_user') ,['class'=>'form-control', 'id'=>'max_user_use' , 'placeholder'=>trans('admin.max_user_use')]) !!}
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
