<div class="row">
    <div class="col-lg-3">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">
                        @if(isset($data))
                        {{trans('admin.edit-brand')}}
                        @else
                        {{trans('admin.add-brand')}}
                        @endif
                    </h4>
                </div>
            </div>
        </div>
        <div class="iq-card">
            <div class="iq-card-body">
                <form>
                    <div class="form-group text-center">
                        <div class="add-img-user profile-img-edit">
                            @if(isset($data) && $data->image != null)
                            <img class="profile-pic img-fluid" src="{{ asset('storage/'.$data->image) }}" alt="profile-pic">
                            @else
                            <img class="profile-pic img-fluid" src="{{ asset('assets/imgs/avatar.png') }}" alt="profile-pic">
                            @endif
                            <div class="p-image">
                                <a href="#" class="upload-button btn iq-bg-primary">{{trans('admin.image')}}</a>
                                <input name="image" class="file-upload" type="file" accept="image/*">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title"> {{trans('admin.brand-info')}}</h4>
                </div>
            </div>
            <div class="iq-card-body">
                @include('admin.include.messages_errors')
                <div class="new-user-info">
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('name' , trans('admin.name')) !!}
                            <span class="asters">*</span>
                            {!! Form::text('name' , $data->name ?? old('name') ,['class'=>'form-control' , 'id'=>'name' , 'placeholder'=>trans('admin.name')]) !!}
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
