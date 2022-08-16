@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('AgencyType_trans.AgencyType')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('AgencyType_trans.AgencyType')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('AgencyType_trans.AgencyType')}}</li>
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
                       data-target="#addAgency_Modola">
                       {{ trans('AgencyType_trans.Add_AgencyType') }}
                     </a>
                 
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('AgencyType_trans.AgencyType')}}</th>
                                <th>{{trans('AgencyType_trans.status')}}</th>
                                <th>{{trans('AgencyType_trans.proccess')}}</th>
                            </tr>
                            </thead>
                            <tbody>d
                            @foreach ($AgencyTypes as $AgencyType)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $AgencyType->name }}</td>
                                    <td>
                                    @if($AgencyType->status=='Active')
                                    <label class="badge badge-success">{{ trans('AgencyType_trans.Active') }}</label>
                                    @else
                                    <label class="badge badge-danger">{{  trans('AgencyType_trans.Not_active') }}</label>
                                    @endif
                                    </td>

                                    <td>
                                       <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('editagency',$AgencyType->id) }}" 
                                                   select_typeid="{{$AgencyType->id}}" 
                                                   data-toggle="modal" 
                                                   data-target="#editagency_modola">
                                                  <i class="fa fa-edit"></i>
                                           </a>  

                                        <a  class="btn btn-danger btn-sm" 
                                               href="#" data-toggle="modal"  data-target="#deleteModola_AgencyType"
                                               delete-id="{{$AgencyType->id}}"
                                              AgencyType_name="{{$AgencyType->name}}">
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

    
 @include('dashboard.admin.AgencyTypes.add')
 @include('dashboard.admin.AgencyTypes.edit')
 @include('dashboard.admin.AgencyTypes.delete')

    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addAgency_Modola  button,#editagency_modola  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
         url=$("#addAgency_Modola form").attr('action');
        
         data={
           name_ar:$("#addAgency_Modola form input[name='AgencyType_ar']").val(),
           name_en:$("#addAgency_Modola form input[name='AgencyType_en']").val(),

          };
          
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editagency_modola form").attr('action');
         data={
           name_ar:$("#editagency_modola form input[name='name_ar']").val(),
           name_en:$("#editagency_modola form input[name='name_en']").val(),
           agency_typeid:$("#editagency_modola form input[name='agency_typeid']").val(),
           status:$("#editagency_modola form input[name='status']").prop('checked')?1:0

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
  $("#editagency_modola").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href
// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
            $("#editagency_modola form input[name='name_ar']").val(data.name['ar']);
            $("#editagency_modola form input[name='name_en']").val(data.name['en']);
            $("#editagency_modola form input[name='agency_typeid']").val(data.id);
        
            if(data.status=="Active")
            $("#editagency_modola form input[name='status']").prop('checked',true);
            else
                $("#editagency_modola form input[name='status']").prop('checked',false);
          
        });
});


   $("#deleteModola_AgencyType").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           var Agency_name=button.attr('AgencyType_name');
           $("#deleteModola_AgencyType label[name='Agency_Typename']").text(Agency_name);
           delete_url="/admin/delete_AgenctType/"+id;
           });

            $("#deleteModola_AgencyType .agency-btn-del").click(function()
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