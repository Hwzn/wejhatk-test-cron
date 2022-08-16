@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('attributetype_trans.attrubite_type')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('attributetype_trans.attrubitetype_list')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('attributetype_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('attributetype_trans.attrubitetype_list')}}</li>
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
                       data-target="#addattributetype_Modola">
                       {{ trans('attributetype_trans.New_typeAttribute') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('attributetype_trans.attrubite_type')}}</th>
                                <th>{{trans('attributetype_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($attribute_types as $attributetype)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $attributetype->name }}</td>
                                    <td>
                                    <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('editattributetype',$attributetype->id) }}" 
                                                   attribute-id="{{$attributetype->id}}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_attributetype">
                                                  <i class="fa fa-edit"></i>
                                    </a>          
                                    <a  class="btn btn-danger btn-sm" 
                                               href="#" data-toggle="modal"  data-target="#deleteModola_attributetype"
                                               delete-id="{{$attributetype->id}}">
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
      
        @include('dashboard.admin.attributetype.add')
        @include('dashboard.admin.attributetype.edit')
         @include('dashboard.admin.attributetype.delete')

    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addattributetype_Modola  button,#editModolad_attributetype  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
         url=$("#addattributetype_Modola form").attr('action');
        
         data={
           attribute_typeName:$("#addattributetype_Modola form input[name='Name']").val(),
          };
          
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_attributetype form").attr('action');
         data={
           Name:$("#editModolad_attributetype form input[name='Name']").val(),
           attributetype_id:$("#editModolad_attributetype form input[name='attributetype_id']").val(),
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
  $("#editModolad_attributetype").on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget) //Button that triggered the modal
    var getHref = button.data('href'); //get button href
    // var update_url="http://127.0.0.1:8000/admin/update_service/";
    // $('#editModolad_service form').attr('action',update_url);

        $.ajax({
            url:getHref,
        }).done(function(data)
            {
               
                $("#editModolad_attributetype form input[name='Name']").val(data.name);
                $("#editModolad_attributetype form input[name='attributetype_id']").val(data.id);

            
            });
    });

    $("#deleteModola_attributetype").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_attribtype/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_attributetype .attribtype-btn-del").click(function()
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
