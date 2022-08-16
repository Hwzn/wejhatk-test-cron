@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('returnploicy_trans.ReturnPloicy')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('returnploicy_trans.ReturnPloicy')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('returnploicy_trans.ReturnPloicy')}}</li>
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
                       data-target="#addpolicy_Modola">
                       {{ trans('returnploicy_trans.New_Policy') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('returnploicy_trans.ploicy_name')}}</th>
                                <th>{{trans('returnploicy_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($retrun_ploicies as $retrun_ploicy)
                                <tr>
                                
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $retrun_ploicy->name }}</td>
                                    <td>
                                       <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('editpolicy',$retrun_ploicy->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_policy">
                                                  <i class="fa fa-edit"></i>
                                           </a>   

                                         <a  class="btn btn-danger btn-sm" 
                                                 href="#" data-toggle="modal"  data-target="#deleteModola_policy"
                                               delete-id="{{$retrun_ploicy->id}}" policyname="{{$retrun_ploicy->name}}">
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


      
 @include('dashboard.admin.RetrunPloicys.add')
 @include('dashboard.admin.RetrunPloicys.edit')
 @include('dashboard.admin.RetrunPloicys.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addpolicy_Modola  button,#editModolad_policy  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
      //  var $check = $("#addpolicy_Modola form input[name='status']").val();
       
         url=$("#addpolicy_Modola form").attr('action');
        
         data={
            name_ar:$("#addpolicy_Modola form textarea[name='name_ar']").val(),
            name_en:$("#addpolicy_Modola form textarea[name='name_en']").val(),
          };
        //   console.log(data);
        //   return;
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_policy form").attr('action');
         data={
             
           name_ar:$("#editModolad_policy form textarea[name='name_ar']").val(),
           name_en:$("#editModolad_policy form textarea[name='name_en']").val(),
           policy_id:$("#editModolad_policy form input[name='policy_id']").val(),
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
  $("#editModolad_policy").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href
// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
           
            $("#editModolad_policy form textarea[name='name_ar']").val(data.name['ar']);
            $("#editModolad_policy form textarea[name='name_en']").val(data.name['en']);
            $("#editModolad_policy form input[name='policy_id']").val(data.id);
            
        });
});


   $("#deleteModola_policy").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           var policy_name1= button.attr('policyname');
           $("#deleteModola_policy label[name='policy_name']").text(policy_name1);

           delete_url="/admin/delete_policy/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_policy .policy-btn-del").click(function()
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
