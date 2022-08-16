@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('otherservice_trans.OtherServices')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('otherservice_trans.OtherServices')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('otherservice_trans.OtherServices')}}</li>
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
                       data-target="#addModolad_OtherService">
                       {{ trans('otherservice_trans.add_OtherServices') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('otherservice_trans.OtherServices')}}</th>
                                <th>{{trans('otherservice_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($OtherServices as $OtherService)
                                <tr>
                                
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $OtherService->name }}</td>
                                   

                                    <td>
                                       <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('edit_otherservies',$OtherService->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_OtherService">
                                                  <i class="fa fa-edit"></i>
                                           </a>   

                                         <a  class="btn btn-danger btn-sm" 
                                                 href="#" data-toggle="modal"  data-target="#deleteModola_OtherService"
                                               delete-id="{{$OtherService->id}}">
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


      
 @include('dashboard.admin.OtherService.add')
 @include('dashboard.admin.OtherService.edit')
 @include('dashboard.admin.OtherService.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addModolad_OtherService  button,#editModolad_OtherService  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
       
         url=$("#addModolad_OtherService form").attr('action');
        
         data={
            name_ar:$("#addModolad_OtherService form input[name='name_ar']").val(),
            name_en:$("#addModolad_OtherService form input[name='name_en']").val(),
          };
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_OtherService form").attr('action');
         data={
             
            name_ar:$("#editModolad_OtherService form input[name='name_ar']").val(),
            name_en:$("#editModolad_OtherService form input[name='name_en']").val(),
            OtherService_id:$("#editModolad_OtherService form input[name='OtherService_id']").val(),
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
  $("#editModolad_OtherService").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
        //    console.log(data);
        //    return;
            $("#editModolad_OtherService form input[name='name_ar']").val(data.name['ar']);
            $("#editModolad_OtherService form input[name='name_en']").val(data.name['en']);

            $("#editModolad_OtherService form input[name='OtherService_id']").val(data.id);
            
        });
});


   $("#deleteModola_OtherService").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_otherservies/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_OtherService .otherservice-btn-del").click(function()
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
