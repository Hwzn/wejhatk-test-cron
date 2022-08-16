@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('ads_trans.scoialmedia_types')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('ads_trans.scoialmedia_types')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('ads_trans.home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('ads_trans.scoialmedia_types')}}</li>
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
                       data-target="#addsocialmediaads_Modola">
                       {{ trans('ads_trans.add_socialmedia') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('ads_trans.name')}}</th>
                                <th>{{trans('ads_trans.status')}}</th>
                                <th>{{trans('ads_trans.proccess')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($SocialMediaTypes as $ads)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $ads->name }}</td>
                                    <td>
                                    @if($ads->status=='active')
                                    <label class="badge badge-success">{{ $ads->status }}</label>
                                    @else
                                    <label class="badge badge-danger">{{ $ads->status }}</label>
                                    @endif
                                    </td>
                                    <td>
                                          
                                        <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('edit_social',$ads->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editsocialModolad_ads">
                                                  <i class="fa fa-edit"></i>
                                           </a>  
                                          
                                      <a  class="btn btn-danger btn-sm" 
                                                 href="#" data-toggle="modal"  data-target="#deletesocialModola_ads"
                                                 delete-id="{{$ads->id}}"
                                                 ads_name="{{$ads->name}}">
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
        @include('dashboard.admin.ads.social_mediatypes.add')
    </div>
    @include('dashboard.admin.ads.social_mediatypes.edit')
    @include('dashboard.admin.ads.social_mediatypes.delete')

    </div>
    <!-- row closed -->


@endsection
@section('js')

<script>
     
     $("#addsocialmediaads_Modola  button,#editsocialModolad_ads  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
      //  var $check = $("#addsocialmediaads_Modola form input[name='status']").val();
     
         url=$("#addsocialmediaads_Modola form").attr('action');
        
         data={
            name_ar:$("#addsocialmediaads_Modola form input[name='name_ar']").val(),
            name_en:$("#addsocialmediaads_Modola form input[name='name_en']").val(),
          };
        //   console.log(data);
        //   return;
        }
        if($(this).attr('type')==='edit')
       {
          
         url=$("#editsocialModolad_ads form").attr('action');
         data={
             
            name_ar:$("#editsocialModolad_ads form input[name='name_ar']").val(),
            name_en:$("#editsocialModolad_ads form input[name='name_en']").val(),
            ads_id:$("#editsocialModolad_ads form input[name='ads_id']").val(),
            status:$("#editsocialModolad_ads form input[name='status']").prop('checked')?1:0
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
  $("#editsocialModolad_ads").on('show.bs.modal', function(event) {
var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href

// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
            $("#editsocialModolad_ads form input[name='name_ar']").val(data.name['ar']);
            $("#editsocialModolad_ads form input[name='name_en']").val(data.name['en']);
            $("#editsocialModolad_ads form input[name='ads_id']").val(data.id);
           
           
            if(data.status=="active")
            $("#editsocialModolad_ads form input[name='status']").prop('checked',true);
            else
                $("#editsocialModolad_ads form input[name='status']").prop('checked',false);
          
            
            
        });
});


  
    $("#deleteModola_ads").on('show.bs.modal', function(event) {
        
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           var ads_name=button.attr('ads_name');
           $("#deleteModola_ads label[name='ads_name']").text(ads_name);
           delete_url="/admin/delete_socialtype/"+id;
          console.log( delete_url);
           });
           
 $("#deleteModola_ads .ads-btn-del").click(function()
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
