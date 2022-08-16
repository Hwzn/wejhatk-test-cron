@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('attribute_trans.attrubites')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('attribute_trans.attrubites_list')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('attribute_trans.attrubites_list')}}</li>
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
                       data-target="#addattribute_Modola">
                       {{ trans('attribute_trans.New_Attribute') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('attribute_trans.Attribute_Name')}}</th>
                                <th>{{trans('attribute_trans.Attribute_Type')}}</th>
                                <th>{{trans('attribute_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($attruibtes as $attruibte)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $attruibte->name }}</td>
                                    <td>{{ $attruibte->attr_type->name }}</td>
                                    <td>
                                         
                                    <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('editattribute',$attruibte->id) }}" 
                                                   attribute-id="{{$attruibte->id}}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_attribute">
                                                  <i class="fa fa-edit"></i>
                                    </a>     
                                    <a  class="btn btn-danger btn-sm" 
                                               href="#" data-toggle="modal"  data-target="#deleteModola_attribute"
                                               delete-id="{{$attruibte->id}}">
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


        <!--includes_ -->
          @include('dashboard.admin.attributes.add')
          @include('dashboard.admin.attributes.edit')
          @include('dashboard.admin.attributes.delete')

       <!--includes_ -->


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addattribute_Modola  button,#editModolad_attribute  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
         url=$("#addattribute_Modola form").attr('action');
        
         data={
           attribute_ar:$("#addattribute_Modola form input[name='Name']").val(),
           attribute_en:$("#addattribute_Modola form input[name='Name_en']").val(),
           attribute_type:$("#addattribute_Modola form select[name='Attribute_Type']").val(),
           
          };
        //   console.log(data);
        //   return;
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_attribute form").attr('action');
         data={
            attribute_ar:$("#editModolad_attribute form input[name='Name']").val(),
            attribute_en:$("#editModolad_attribute form input[name='Name_en']").val(),
           attri_typeid:$("#editModolad_attribute form select[name='Attribute_Type']").val(),
           attribute_id:$("#editModolad_attribute form input[name='attribute_id']").val()
        
          };
         
        //  console.log(data);
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
  $("#editModolad_attribute").on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget) //Button that triggered the modal
    var getHref = button.data('href'); //get button href
  
    // var update_url="http://127.0.0.1:8000/admin/update_service/";
    // $('#editModolad_service form').attr('action',update_url);

        $.ajax({
            url:getHref,
        }).done(function(data)
            {
              console.log(data);
                $("#editModolad_attribute form input[name='Name']").val(data.name['ar']);
                $("#editModolad_attribute form input[name='Name_en']").val(data.name['en']);
                $("select[name='Attribute_Type']").val(data.attr_typeid);
                $("select[name='Attribute_Type']").val(data.attr_typeid).change();

                $("#editModolad_attribute form input[name='attribute_id']").val(data.id);

                
            });
    });

    $("#deleteModola_attribute").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_attribute/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_attribute .attribute-btn-del").click(function()
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
