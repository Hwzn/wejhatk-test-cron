@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('main_trans.Services')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('main_trans.Services_list')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('main_trans.Services_list')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<div class="row">   

<div class="col-md-12 mb-30" id="update_Form">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <form enctype="multipart/form-data" method="post" action="">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6 border-right-2 border-right-blue-400">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label font-weight-semibold">UserName<span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="username"  id="username"value="{{ $settings->name }}" required type="text" class="form-control" placeholder="Name of School">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label font-weight-semibold">الهاتف</label>
                                <div class="col-lg-9">
                                    <input name="phone" value="{{ $settings->phone }}" type="text" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label font-weight-semibold">كلمة المرور</label>
                                <div class="col-lg-9">
                                    <input name="password" value="{{ $settings->password }}" type="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label font-weight-semibold">تأكيد كلمة المرور</label>
                                <div class="col-lg-9">
                                    <input name="password_confirm" value="{{ $settings->password }}" type="password" class="form-control" placeholder="Repeat Password">
                                </div>
                            </div>
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" id="Update_Setting" type="add">{{trans('Students_trans.submit')}}</button>
                </form>
            </div>
        </div>
    </div>



      

    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#Update_Setting").click(function(e)
   {
    e.preventDefault();
     
        // url=$("#addservice_Modola form").attr('action');
        alert($("#update_Form form input[name='user_name']").val()),

         data={
            //user_name:$("#username").val(),
             user_name:$("input[name='user_name']").val(),
            // password:$("#addservice_Modola form input[name='Name_en']").val(),
            // password_confirm:$("#addservice_Modola form input[name='Name_en']").val(),

          };

         $.ajax({
           url:url,
           data:data,
           type:'POST',
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           
           success:function(data)
            {
                if(data.hasOwnProperty('success')){
                    location.reload(true);
               }else{
                   
                   printErrorMsg(data.error);
               }
            }
         });
     
   
   });
   //end add service

 
    

   function printErrorMsg (msg)
    {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
    }
</script>
   @toastr_js
    @toastr_render
@endsection