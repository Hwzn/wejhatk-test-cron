@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('cartypes_trans.car_types')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('cartypes_trans.car_types')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('cartypes_trans.car_types')}}</li>
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
                       data-target="#addcartype_Modola">
                       {{ trans('cartypes_trans.add_cartype') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('cartypes_trans.car_type')}}</th>
                                <th>{{trans('cartypes_trans.status')}}</th>
                                <th>{{trans('cartypes_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($car_types as $car_type)
                                <tr>
                                
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $car_type->name }}</td>
                                    <td>

                                    @if($car_type->status=='enabled')
                                    <label class="badge badge-success">{{ $car_type->status }}</label>
                                    @else
                                    <label class="badge badge-danger">{{ $car_type->status }}</label>
                                    @endif
                                       
                                       
                                       
                                       </td>

                                    <td>
                                       <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('edit_cartype',$car_type->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_cartype">
                                                  <i class="fa fa-edit"></i>
                                           </a>   

                                         <a  class="btn btn-danger btn-sm" 
                                                 href="#" data-toggle="modal"  data-target="#deleteModola_cartype"
                                               delete-id="{{$car_type->id}}">
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


      
 @include('dashboard.admin.car_type.add')
 @include('dashboard.admin.car_type.edit')
 @include('dashboard.admin.car_type.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addcartype_Modola  button,#editModolad_cartype  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
       
         url=$("#addcartype_Modola form").attr('action');
        
         data={
            name_ar:$("#addcartype_Modola form input[name='name_ar']").val(),
            name_en:$("#addcartype_Modola form input[name='name_en']").val(),
          };
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_cartype form").attr('action');
         data={
             
            name_ar:$("#editModolad_cartype form input[name='name_ar']").val(),
            name_en:$("#editModolad_cartype form input[name='name_en']").val(),
            cartype_id:$("#editModolad_cartype form input[name='cartype_id']").val(),
            status:$("#editModolad_cartype form input[name='status']").prop('checked')?1:0
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
  $("#editModolad_cartype").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
        //    console.log(data);
        //    return;
            $("#editModolad_cartype form input[name='name_ar']").val(data.name['ar']);
            $("#editModolad_cartype form input[name='name_en']").val(data.name['en']);

            $("#editModolad_cartype form input[name='cartype_id']").val(data.id);
           if(data.status=='enabled')
            $("#editModolad_cartype form input[name='status']").prop('checked',true);
            else
                $("#editModolad_cartype form input[name='status']").prop('checked',false);
            
            
        });
});


   $("#deleteModola_cartype").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_cartype/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_cartype .cartype-btn-del").click(function()
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
