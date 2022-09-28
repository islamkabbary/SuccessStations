@extends('admin.layout.base')

@section('title', trans('admin.edit-promo_code'))

@section('content')
    {!! Form::open(['method'=>'put' , 'route'=>['promo_codes.update' , $data->id] ,'enctype'=>'multipart/form-data'  , 'id'=>'edit-user-form']) !!}
        @method('PUT')
        @include('admin.promo_codes.inputs')
    {!! Form::close() !!}
@endsection
@section('script')
<script>
    $(document).ready(function(){
        @if(old('type'))
            checkType("{{ old('type') }}");
        @endif

        $('#type').on('change' , function(){
            var value = $(this).val();
            checkType(value);
        });

        function checkType(value){
            if(value == 'percentage'){
                $('#max_discount_c *').removeClass('d-none');
                $('#max_discount').removeAttr('readonly');
            }else{
                $('#max_discount_c *').addClass('d-none');
                $('#max_discount').attr('readonly' , 'readonly');
            }
        }
    });


</script>
@endsection
