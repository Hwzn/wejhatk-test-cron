@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('Terms_trans.TermsAndConditions')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('Terms_trans.TermsAndConditions')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('Terms_trans.TermsAndConditions')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<div class="row">   

      <div class="" style="width: 100%;" id="addTermsCondition_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('Terms_trans.TermsAndConditions') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                         <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                         </div>
                        <!-- add_form -->
                        <form action="{{route('add_termsconditions')}}" method="POST">
                            @csrf
                          
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('Terms_trans.dsec_ar') }}
                                    :</label>
                               
                                   <textarea class="form-control" name="desc_ar" id="exampleFormControlTextarea1"
                                          rows="3">
                                          @if(!empty($TermsandConditions))
                                          {!! $TermsandConditions->getTranslation('desc','ar') !!}
                                          @else
                                         
                                           @endif
                                          </textarea>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('Terms_trans.dsec_en') }}
                                    :</label>
                                    <textarea class="form-control" name="desc_en" id="exampleFormControlTextarea1"
                                          rows="3">
                                          @if(!empty($TermsandConditions))
                                          {!! $TermsandConditions->getTranslation('desc','en') !!}
                                          @else
                                         
                                           @endif                                   
                                         </textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button  type="add"
                                class="btn btn-success">{{ trans('Service_trans.submit') }}</button>
                    </div>
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
   $("#addTermsCondition_Modola  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
        url=$("#addTermsCondition_Modola form").attr('action');
        
         data={
           desc_ar:$("#addTermsCondition_Modola form textarea[name='desc_ar']").val(),
           desc_en:$("#addTermsCondition_Modola form textarea[name='desc_en']").val()

          };
          
        }
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