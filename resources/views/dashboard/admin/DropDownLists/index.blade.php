@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('DropDownLists_trans.DropDownList_List')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->dd
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('DropDownLists_trans.DropDownList_List')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('DropDownLists_trans.DropDownList_List')}}</li>
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
                       data-target="#addDropDownLists_Modola">
                       {{ trans('DropDownLists_trans.Add_DropDownList') }}
                     </a>
                 
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('DropDownLists_trans.name')}}</th>
                                <th>{{trans('DropDownLists_trans.proccess')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($SelectTypes as $SelectType)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $SelectType->name }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('editDropDwonlist',$SelectType->id) }}" 
                                                   select_typeid="{{$SelectType->id}}" 
                                                   data-toggle="modal" 
                                                   data-target="#editDropDownList_Modola">
                                                  <i class="fa fa-edit"></i>
                                           </a>    

                                         <a  class="btn btn-danger btn-sm" 
                                               href="#" data-toggle="modal"  data-target="#deleteModola_DropDown"
                                               delete-id="{{$SelectType->id}}"
                                               DropDown_name="{{$SelectType->name}}">
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

    
      @include('dashboard.admin.DropDownLists.add')
      @include('dashboard.admin.DropDownLists.edit')
      @include('dashboard.admin.DropDownLists.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addDropDownLists_Modola  button,#editDropDownList_Modola  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
         url=$("#addDropDownLists_Modola form").attr('action');
        
         data={
           name:$("#addDropDownLists_Modola form input[name='name']").val(),
          };
          
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editDropDownList_Modola form").attr('action');
         data={
           name:$("#editDropDownList_Modola form input[name='name']").val(),
           select_typeid:$("#editDropDownList_Modola form input[name='select_typeid']").val()
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
  $("#editDropDownList_Modola").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href
// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
            $("#editDropDownList_Modola form input[name='name']").val(data.name);
            $("#editDropDownList_Modola form input[name='select_typeid']").val(data.id);
        });
});


   $("#deleteModola_DropDown").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           var DropDown_name=button.attr('DropDown_name');
           $("#deleteModola_DropDown label[name='DropDown_list']").text(DropDown_name);

        //    $("#deleteModola_Package label[name='pakage_name']").text(package_name);

           delete_url="/admin/delete_DropDownList/"+id;
           });

            $("#deleteModola_DropDown .DropDown-btn-del").click(function()
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