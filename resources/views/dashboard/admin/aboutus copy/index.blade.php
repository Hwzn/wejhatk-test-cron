@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('Aboutus_trans.aboutus')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('Aboutus_trans.aboutus')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('Aboutus_trans.aboutus')}}</li>
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
                       data-target="#addaboutus_Modola">
                       {{ trans('Aboutus_trans.New_Define') }}
                     </a>
                 
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('Aboutus_trans.aboutus')}}</th>
                                <th>{{trans('Aboutus_trans.proccess')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($aboutus as $aboutus)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{!! $aboutus->desc !!}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('editaboutus',$aboutus->id) }}" 
                                                   service-id="{{$aboutus->id}}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_aboutus">
                                                  <i class="fa fa-edit"></i>
                                           </a>    

                                         <a  class="btn btn-danger btn-sm" 
                                               href="#" data-toggle="modal"  data-target="#deleteModola_aboutus"
                                               delete-id="{{$aboutus->id}}">
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

      @include('dashboard.admin.aboutus.add')
      @include('dashboard.admin.aboutus.edit')
      @include('dashboard.admin.aboutus.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addaboutus_Modola  button,#editModolad_aboutus  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
         url=$("#addaboutus_Modola form").attr('action');
        
         data={
           desc_ar:$("#addaboutus_Modola form textarea[name='desc_ar']").val(),
           desc_en:$("#addaboutus_Modola form textarea[name='desc_en']").val()

          };
          
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editModolad_aboutus form").attr('action');
         data={
           desc_ar:$("#editModolad_aboutus form textarea[name='desc_ar']").val(),
           desc_en:$("#editModolad_aboutus form textarea[name='desc_en']").val(),
           aboutus_id:$("#editModolad_aboutus form input[name='aboutus_id']").val()
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
  $("#editModolad_aboutus").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href
// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
           console.log(data);
            $("#editModolad_aboutus form textarea[name='desc_ar']").val(data.desc['ar']);
            $("#editModolad_aboutus form textarea[name='desc_en']").val(data.desc['en']);
            $("#editModolad_aboutus form input[name='aboutus_id']").val(data.id);

            
        });
});


   $("#deleteModola_aboutus").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_aboutus/"+id;
           });

            $("#deleteModola_aboutus .about-btn-del").click(function()
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