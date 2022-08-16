@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('CommonQuestions_trans.CommonQuestions')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('CommonQuestions_trans.CommonQuestions')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('CommonQuestions_trans.CommonQuestions')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<div class="row">   

<div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                   

                   
                    <a href="#" class="button x-small" role="button" aria-disabled="true"
                       data-toggle="modal" 
                       data-target="#addquestion_Modola">
                       {{ trans('CommonQuestions_trans.New_Question') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('CommonQuestions_trans.question')}}</th>
                                <th>{{trans('CommonQuestions_trans.answer')}}</th>
                                <th>{{trans('CommonQuestions_trans.status')}}</th>
                                <th>{{trans('CommonQuestions_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($commonquestions as $commonquestion)
                                <tr>
                                
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $commonquestion->question }}</td>
                                    <td>{{ $commonquestion->answer }}</td>
                                    <td>{{ $commonquestion->status==1?trans('CommonQuestions_trans.Active'):trans('CommonQuestions_trans.NotActive') }}</td>

                                    <td>
                                       <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('editquestion',$commonquestion->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_question">
                                                  <i class="fa fa-edit"></i>
                                           </a>   

                                         <a  class="btn btn-danger btn-sm" 
                                                 href="#" data-toggle="modal"  data-target="#deleteModola_question"
                                               delete-id="{{$commonquestion->id}}">
                                               <i class="fa fa-trash"></i>
                                         </a>
                                        
                                         

                                    </td>
                                </tr>

                              @endforeach
                            </tbody>
                        </table>
               
                    </div>
                </div>
            </div>
 </div>


      
 @include('dashboard.admin.commonquestion.add')
 @include('dashboard.admin.commonquestion.edit')
 @include('dashboard.admin.commonquestion.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addquestion_Modola  button,#editModolad_question  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
      //  var $check = $("#addquestion_Modola form input[name='status']").val();
       
         url=$("#addquestion_Modola form").attr('action');
        
         data={
            question_ar:$("#addquestion_Modola form input[name='question_ar']").val(),
            question_en:$("#addquestion_Modola form input[name='question_en']").val(),
            answer_ar:$("#addquestion_Modola form textarea[name='answer_ar']").val(),
            answer_en:$("#addquestion_Modola form textarea[name='answer_en']").val(),
            //status:$check.prop('checked')?$check.val():0
            status:$("#addquestion_Modola form input[name='status']").prop('checked')?1:0
          };
        //   console.log(data);
        //   return;
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_question form").attr('action');
         data={
             
            question_ar:$("#editModolad_question form input[name='question_ar']").val(),
            question_en:$("#editModolad_question form input[name='question_en']").val(),
           answer_ar:$("#editModolad_question form textarea[name='answer_ar']").val(),
           answer_en:$("#editModolad_question form textarea[name='answer_en']").val(),
            question_id:$("#editModolad_question form input[name='question_id']").val(),
            status:$("#editModolad_question form input[name='status']").prop('checked')?1:0
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
     //onedit show modola
  $("#editModolad_question").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href
// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
           
            $("#editModolad_question form input[name='question_ar']").val(data.question['ar']);
            $("#editModolad_question form input[name='question_en']").val(data.question['en']);
            $("#editModolad_question form textarea[name='answer_ar']").val(data.answer['ar']);
            $("#editModolad_question form textarea[name='answer_en']").val(data.answer['en']);
            $("#editModolad_question form textarea[name='answer_en']").val(data.answer['en']);

            $("#editModolad_question form input[name='question_id']").val(data.id);
            // $("#editModolad_question form input[name='status']").val(data.status);
           if(data.status==1)
            $("#editModolad_question form input[name='status']").prop('checked',true);
            else
                $("#editModolad_question form input[name='status']").prop('checked',false);
            
            
        });
});


   $("#deleteModola_question").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_question/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_question .question-btn-del").click(function()
 {
               $.ajax({
                       url:delete_url,    
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                       type:"post"
                       }).done(function(data) {
                        location.reload(true);
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
