@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('consulationtype_trans.Consultion_Types')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('consulationtype_trans.Consultion_Types')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('consulationtype_trans.Consultion_Types')}}</li>
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
                       data-target="#addModolad_ConsultationType">
                       {{ trans('consulationtype_trans.add_ConsultionType') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('consulationtype_trans.Consultion_Types')}}</th>
                                <th>{{trans('consulationtype_trans.BelongsTo')}}</th>
                                <th>{{trans('consulationtype_trans.status')}}</th>
                                <th>{{trans('consulationtype_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ConsultationTypes as $ConsultationType)
                                <tr>
                                
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $ConsultationType->name }}</td>
                                    <td>{{ $ConsultationType->type }}</td>
                                    <td>
                                    @if($ConsultationType->status=='active')
                                    <label class="badge badge-success">{{ $ConsultationType->status }}</label>
                                    @else
                                    <label class="badge badge-danger">{{ $ConsultationType->status }}</label>
                                    @endif
                                    </td>
                                    <td>
                                       <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('edit_consultationtype',$ConsultationType->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_ConsultationType">
                                                  <i class="fa fa-edit"></i>
                                           </a>   

                                         <a  class="btn btn-danger btn-sm" 
                                                 href="#" data-toggle="modal"  data-target="#deleteModola_ConsultationType"
                                               delete-id="{{$ConsultationType->id}}">
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


      
 @include('dashboard.admin.ConsultationType.add')
 @include('dashboard.admin.ConsultationType.edit')
 @include('dashboard.admin.ConsultationType.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addModolad_ConsultationType  button,#editModolad_ConsultationType  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
       
         url=$("#addModolad_ConsultationType form").attr('action');
        
         data={
            name_ar1:$("#addModolad_ConsultationType form input[name='name_ar']").val(),
            name_en1:$("#addModolad_ConsultationType form input[name='name_en']").val(),
            type:$("#addModolad_ConsultationType form select[name='type']").val(),

        };
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_ConsultationType form").attr('action');
         data={
             
            name_ar:$("#editModolad_ConsultationType form input[name='name_ar']").val(),
            name_en:$("#editModolad_ConsultationType form input[name='name_en']").val(),
            consultationtype_id:$("#editModolad_ConsultationType form input[name='consultationtype_id']").val(),
            status:$("#editModolad_ConsultationType form input[name='status']").prop('checked')?1:0,
            type:$("#editModolad_ConsultationType form select[name='type']").val(),

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
  $("#editModolad_ConsultationType").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
        //    console.log(data);
        //    return;
            $("#editModolad_ConsultationType form input[name='name_ar']").val(data.name['ar']);
            $("#editModolad_ConsultationType form input[name='name_en']").val(data.name['en']);
            $("#editModolad_ConsultationType form input[name='consultationtype_id']").val(data.id);
            $("#editModolad_ConsultationType form select[name='type']").val(data.type);
            $("#editModolad_ConsultationType form select[name='type']").val(data.type).change();

            if(data.status=="active")
            $("#editModolad_ConsultationType form input[name='status']").prop('checked',true);
            else
                $("#editModolad_ConsultationType form input[name='status']").prop('checked',false);
          
        });
});


   $("#deleteModola_ConsultationType").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_consultationtype/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_ConsultationType .consultiontype-btn-del").click(function()
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
