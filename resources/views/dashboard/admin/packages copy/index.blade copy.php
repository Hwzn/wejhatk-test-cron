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

<div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                   

                   
                    <a href="#" class="button x-small" role="button" aria-disabled="true"
                       data-toggle="modal" 
                       data-target="#addservice_Modola">
                       {{ trans('Service_trans.New_Service') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('Service_trans.Service_Name')}}</th>
                                <th>{{trans('Service_trans.Service_desc')}}</th>
                                <th>{{trans('Service_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($services as $service)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->desc }}</td>
                                    <td>
                                          <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('editservice',$service->id) }}" 
                                                   service-id="{{$service->id}}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_service">
                                                  <i class="fa fa-edit"></i>
                                           </a>     

                                           <a  class="btn btn-danger btn-sm" 
                                               href="#" data-toggle="modal"  data-target="#deleteModola_service"
                                               delete-id="{{$service->id}}">
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


        <!-- add_modal_ -->
      
        @include('dashboard.admin.services.add')
         @include('dashboard.admin.services.edit')
         @include('dashboard.admin.services.delete')

    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')

<script>
        var loadFile = function(event) {
            var output = document.getElementById('imgservice');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

<script>
        var loadFile1 = function(event) {
            var output = document.getElementById('img_service');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
<script>
$("#addservice_Modola  button").click(function(e)
   {
    e.preventDefault();
       var fd = new FormData();
        var files = $('#file')[0].files;
         url=$("#addservice_Modola form").attr('action');
        if(files.length > 0 )
        {
            fd.append('file',files[0]);
        }
        fd.append('service_ar',$("#addservice_Modola form input[name='Name']").val());
        fd.append('service_en',$("#addservice_Modola form input[name='Name_en']").val());
        fd.append('desc',$("#addservice_Modola form textarea[name='Notes']").val());

        $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: url,
               type: 'post',
               data:fd,  
               contentType: false,
               processData: false,
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
   $("#editModolad_service  button").click(function(e)
   {

    e.preventDefault();
       var fd = new FormData();
        var files = $('#file2')[0].files;
         url=$("#editModolad_service form").attr('action');
        if(files.length > 0 )
        {
            fd.append('file',files[0]);
        }
        // fd.append('service_ar',$("#addservice_Modola form input[name='Name']").val());
         fd.append('service_ar',$("#editModolad_service form input[name='Name']").val());
         fd.append('service_en',$("#editModolad_service form input[name='Name_en']").val());
         fd.append('desc',$("#editModolad_service form textarea[name='desc']").val());
         fd.append('service_id',$("#editModolad_service form input[name='service_id']").val());
         fd.append('oldimage',$("#editModolad_service form input[name='oldimage']").val());
 
        $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: url,
               type: 'post',
               data:fd,  
               contentType: false,
               processData: false,
               success:function(data)
            {
                console.log(fd);
 return;
                if(data.hasOwnProperty('success')){

                    location.reload(true);
               }else{
                   
                   printErrorMsg(data.error);
               }
            }
            });
         

    /////////
    e.preventDefault();
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_service form").attr('action');
         data={
           service_ar:$("#editModolad_service form input[name='Name']").val(),
           service_en:$("#editModolad_service form input[name='Name_en']").val(),
           desc:$("#editModolad_service form textarea[name='desc']").val(),
           service_id:$("#editModolad_service form input[name='service_id']").val()
        
          };
         
        //  console.log(url);
        //  return;
        }
        //  $.ajax({
        //    url:url,
        //    data:data,
        //    type:'POST',
        //    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           
        //    success:function(data)
        //     {
        //         if(data.hasOwnProperty('success')){
        //             location.reload(true);
        //        }else{
                   
        //            printErrorMsg(data.error);
        //        }
        //     }
        //  });
     
   
   });
   //end add service

  //onedit show modola
  $("#editModolad_service").on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget) //Button that triggered the modal
    var getHref = button.data('href'); //get button href
    // var update_url="http://127.0.0.1:8000/admin/update_service/";
    // $('#editModolad_service form').attr('action',update_url);

        $.ajax({
            url:getHref,
        }).done(function(data)
            {
               console.log(data);
            //    return;
                $("#editModolad_service form input[name='Name']").val(data.name['ar']);
                $("#editModolad_service form input[name='Name_en']").val(data.name['en']);
                $("#editModolad_service form textarea[name='desc']").val(data.desc);
                $("#editModolad_service form input[name='service_id']").val(data.id);
                $("#editModolad_service form input[name='oldimage']").val(data.photo);
 
            });
    });

    $("#deleteModola_service").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_service/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_service .service-btn-del").click(function()
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
