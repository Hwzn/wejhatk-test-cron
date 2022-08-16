@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('ads_trans.photoslider')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('ads_trans.photoslider')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('ads_trans.photoslider')}}</li>
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
                       data-target="#addSliderPhoto_Modola">
                       {{ trans('ads_trans.add_SliderPhoto') }}
                     </a>
                 
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('ads_trans.photo')}}</th>
                                <th>{{trans('ads_trans.expire_date')}}</th>
                                <th>{{trans('ads_trans.status')}}</th>
                                <th>{{trans('ads_trans.download')}}</th>
                                <th>{{trans('ads_trans.proccess')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($popslider as $ads)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td width="40%">
                                     @if($ads->photo !==null)
                                       <img  src="{{ URL::asset('assets/uploads/popup_slider/'.$ads->photo) }}" width="15%" alt="">
                                      @else
                                      @endif
                                    </td>
                                    <td>{{ $ads->expired_at }}</td>
                                    <td>
                                    @if($ads->status=='active')
                                    <label class="badge badge-success">{{ trans('ads_trans.Active') }}</label>
                                    @else
                                    <label class="badge badge-danger">{{  trans('ads_trans.Not_active') }}</label>
                                    @endif
                                    </td>
                                    <td>
                                    @if(!empty($ads->photo))
                                       @if(!is_null($ads->photo))
                                          <a class="btn btn-outline-info btn-sm"
                                                           href="{{route('view_popattachment',$ads->photo)}}"
                                                        role="button"><i class="fas fa-download"></i>&nbsp; {{trans('ads_trans.View')}}</a>
                                        
                                         @else

                                         @endif
                                      @endif
                                    </td>
                                    <td>
                                       <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('editpopupslider',$ads->id) }}" 
                                                   select_typeid="{{$ads->id}}" 
                                                   data-toggle="modal" 
                                                   data-target="#editSliderPhoto_Modola">
                                                  <i class="fa fa-edit"></i>
                                           </a>  

                                        <a  class="btn btn-danger btn-sm" 
                                               href="#" data-toggle="modal"  data-target="#deleteModola_popuoslider"
                                               delete-id="{{$ads->id}}"
                                               image="{{$ads->photo}}">
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

    @include('dashboard.admin.ads.popupads.popupphoto_slider.add')
    @include('dashboard.admin.ads.popupads.popupphoto_slider.edit')
    @include('dashboard.admin.ads.popupads.popupphoto_slider.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')


   <script>
        var loadFile = function(event) {
            var output = document.getElementById('imgservice1');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
      <script>
        var loadFile2 = function(event) {
            var output = document.getElementById('imgservice');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

<script>
$("#addSliderPhoto_Modola  button").click(function(e)
   {
       e.preventDefault();
    //    console.log('dddddd');
    //    return;
    if($(this).attr('type')==='add')
       {
        var fd = new FormData();
        var files = $('#file')[0].files;
            // console.log(files);
            // return;
         url=$("#addSliderPhoto_Modola form").attr('action');
        if(files.length > 0 )
        {
            // console.log('ffff');
            //     return;
            fd.append('file',files[0]);
        }
         fd.append('expired_at',$("#addSliderPhoto_Modola form input[name='expired_at']").val());
        //  console.log(fd);
        //         return;
        $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: url,
               type: 'post',
               data:fd,  
               contentType: false,
               processData: false,
               success:function(data)
            {
                // console.log(data);
                // return;
                if(data.hasOwnProperty('success')){
                    location.reload(true);
               }else{
                   
                   printErrorMsg(data.error);
               }
            }
            });
         
        
       }
      
       
        
     
   
   });
 
 
   $("#editSliderPhoto_Modola  button").click(function(e)
   {
       e.preventDefault();
       if($(this).attr('type')==='edit')
       {
        var fd = new FormData();
        var files = $('#file2')[0].files;
        // console.log(files);
        // return;
         url=$("#editSliderPhoto_Modola form").attr('action');
        if(files.length > 0 )
        {
           
            fd.append('file',files[0]);
        }
      
         fd.append('expired_at',$("#editSliderPhoto_Modola form input[name='expired_at']").val());
         fd.append('oldphoto',$("#editSliderPhoto_Modola form input[name='oldphoto']").val());
         fd.append('id',$("#editSliderPhoto_Modola form input[name='id']").val());
        fd.append('status',$("#editSliderPhoto_Modola form input[name='status']").prop('checked')?1:0);
       
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
         
        
       
       }
     
        
     
   
   });
 
//edit

$("#editSliderPhoto_Modola").on('show.bs.modal', function(event) {
var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href

// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
            console.log(data);
            //return;
            $("#editSliderPhoto_Modola form input[name='expired_at']").val(data.expired_at);
            $("#editSliderPhoto_Modola form input[name='id']").val(data.id);
            $("#editSliderPhoto_Modola form input[name='oldphoto']").val(data.photo);
           $("#imgservice").attr("src","{{ URL::asset('assets/uploads/popup_slider/') }}" +'/'+data.photo);
          
            if(data.status=="active")
            $("#editSliderPhoto_Modola form input[name='status']").prop('checked',true);
            else
                $("#editSliderPhoto_Modola form input[name='status']").prop('checked',false);
          
            
            
        });
});


//edit

    $("#deleteModola_popuoslider").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           var photo = button.attr('image');
          // alert(photo);
        //    var current_image="{{ URL::asset('assets/uploads/popup_slider/') }}" +'/'+photo;

           $("#img").attr("src","{{ URL::asset('assets/uploads/popup_slider/') }}" +'/'+photo);
           delete_url="/admin/delete_popslider/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_popuoslider .delte-btn-del").click(function()
 {
      
    $.ajax({
                       url:delete_url,    
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                       type:"post"

                       }).done(function(data) {
                        //    console.log(data);
                        //    return;
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
