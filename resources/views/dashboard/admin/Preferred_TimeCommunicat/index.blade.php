@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('TimeCommunicate_trans.preferred time communicate')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('TimeCommunicate_trans.preferred time communicate')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('TimeCommunicate_trans.preferred time communicate')}}</li>
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
                       data-target="#addmethodcommunicate_Modola">
                       {{ trans('TimeCommunicate_trans.add_time communicate') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('TimeCommunicate_trans.preferred time')}}</th>
                                <th>{{trans('TimeCommunicate_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($Preferred_Time as $Preferred_Time)
                                <tr>
                                
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $Preferred_Time->name }}</td>
                                   

                                    <td>
                                       <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('edit_timeCommunicate',$Preferred_Time->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_MethodCommunicate">
                                                  <i class="fa fa-edit"></i>
                                           </a>   

                                         <a  class="btn btn-danger btn-sm" 
                                                 href="#" data-toggle="modal"  data-target="#deleteModola_timeCommunicate"
                                               delete-id="{{$Preferred_Time->id}}">
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


      
 @include('dashboard.admin.Preferred_TimeCommunicat.add')
 @include('dashboard.admin.Preferred_TimeCommunicat.edit')
 @include('dashboard.admin.Preferred_TimeCommunicat.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addmethodcommunicate_Modola  button,#editModolad_MethodCommunicate  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
       
         url=$("#addmethodcommunicate_Modola form").attr('action');
        
         data={
            name:$("#addmethodcommunicate_Modola form input[name='name']").val(),
          };
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_MethodCommunicate form").attr('action');
         data={
             
            name:$("#editModolad_MethodCommunicate form input[name='name']").val(),
            timecommunicate_id:$("#editModolad_MethodCommunicate form input[name='timecommunicate_id']").val(),
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
  $("#editModolad_MethodCommunicate").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
        //    console.log(data);
        //    return;
            $("#editModolad_MethodCommunicate form input[name='name']").val(data.name);

            $("#editModolad_MethodCommunicate form input[name='timecommunicate_id']").val(data.id);
            
        });
});


   $("#deleteModola_timeCommunicate").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_timecommunicate/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_timeCommunicate .timecommunicate-btn-del").click(function()
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
