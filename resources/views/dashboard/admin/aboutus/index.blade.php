@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('Aboutus_trans.aboutus')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('Aboutus_trans.aboutus')}}</h4>
        </div>
        
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('Aboutus_trans.aboutus')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<div class="row">   

<div class="col-md-12 mb-30" id="add_Form">
        <div class="card card-statistics h-100">
            <div class="card-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
               <ul></ul>
           </div>
                <form id="addaboutus" enctype="multipart/form-data" method="post" action="{{route('addaboutus')}}">
                    @csrf
                    <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('Aboutus_trans.ar_desc') }}
                                    :</label>
                                <textarea class="form-control" name="desc_ar" id="exampleFormControlTextarea1"
                                          rows="3">{{ $aboutus->getTranslation('desc', 'ar') }}</textarea>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('Aboutus_trans.en_desc') }}
                                    :</label>
                                <textarea class="form-control" name="desc_en" id="exampleFormControlTextarea1"
                                          rows="3">{{ $aboutus->getTranslation('desc', 'en') }}</textarea>
                            </div>
                            
                            <br><br>
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" id="add_contatus" type="add">{{trans('Aboutus_trans.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
 </div>



  
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#add_contatus").click(function(e)
   {
      
    e.preventDefault();
     
         url=$("#add_Form form").attr('action');
       
         data={
           desc_ar:$("textarea[name='desc_ar']").val(),
           desc_en:$("textarea[name='desc_en']").val()

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