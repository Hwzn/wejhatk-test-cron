@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('helps_trans.Helps_Types')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('helps_trans.Helps_Types')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('helps_trans.Helps_Types')}}</li>
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
                       data-target="#addhelp_Modola">
                       {{ trans('helps_trans.Add_HelpType') }}
                     </a>
                 
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('helps_trans.helpname')}}</th>
                                <th>{{trans('helps_trans.proccess')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($helps as $help)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $help->name }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('edithelp',$help->id) }}" 
                                                   service-id="{{$help->id}}" 
                                                   data-toggle="modal" 
                                                   data-target="#edithelp_Modola">
                                                  <i class="fa fa-edit"></i>
                                           </a>    

                                         <a  class="btn btn-danger btn-sm" 
                                               href="#" data-toggle="modal"  data-target="#deleteModola_help"
                                               delete-id="{{$help->id}}">
                                               <i class="fa fa-trash"></i>
                                            </a>deleteModola_Package
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
               
                    </div>
                </div>
            </div>
 </div>

    
      @include('dashboard.admin.helps.add')
      @include('dashboard.admin.helps.edit')
      @include('dashboard.admin.helps.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addhelp_Modola  button,#edithelp_Modola  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
         url=$("#addhelp_Modola form").attr('action');
        
         data={
           name_ar:$("#addhelp_Modola form input[name='name_ar']").val(),
           name_en:$("#addhelp_Modola form input[name='name_en']").val()
          };
          
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#edithelp_Modola form").attr('action');
         data={
           name_ar:$("#edithelp_Modola form input[name='name_ar']").val(),
           name_en:$("#edithelp_Modola form input[name='name_en']").val(),
           help_id:$("#edithelp_Modola form input[name='help_id']").val()
          };
         
        //  console.log(url);
        //  return;
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
   //end add service

   
  //onedit show modola
  $("#edithelp_Modola").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href
// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
            $("#edithelp_Modola form input[name='name_ar']").val(data.name['ar']);
            $("#edithelp_Modola form input[name='name_en']").val(data.name['en']);
            $("#edithelp_Modola form input[name='help_id']").val(data.id);
        });
});


   $("#deleteModola_help").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_help/"+id;
           });

            $("#deleteModola_help .about-btn-del").click(function()
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