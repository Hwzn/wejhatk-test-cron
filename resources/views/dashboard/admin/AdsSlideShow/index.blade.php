@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('main_trans.AdsSlideShow')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('main_trans.AdsSlideShow')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('main_trans.AdsSlideShow')}}</li>
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
                       data-target="#addads_Modola">
                       {{ trans('AdsSlideShow_trans.New_Ads') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('AdsSlideShow_trans.Ads_photo')}}</th>
                                <th>{{trans('AdsSlideShow_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($AdsSlideShows as $AdsSlideShow)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>
                                     <img style="width:200px;height:100px;" src="{{asset('assets/uploads/AdsSlideShow/'.$AdsSlideShow->photo)}}" alt="{{$AdsSlideShow->photo}}" />
                                   </td>
                                    <td>

                                    <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('edit_adsslide',$AdsSlideShow->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_AdsSlideShow">
                                                  <i class="fa fa-edit"></i>
                                           </a>   

                                    <a  class="btn btn-danger btn-sm" 
                                               href="#" data-toggle="modal"  data-target="#deleteModola_AdsSlideShow"
                                               delete-id="{{$AdsSlideShow->id}}">
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
      
        @include('dashboard.admin.AdsSlideShow.add')
        @include('dashboard.admin.AdsSlideShow.edit')
        @include('dashboard.admin.AdsSlideShow.delete')

    </div>
    </div>
    <!-- row closed -->
    

@endsection
@section('js')

  <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

<script>
        var loadFile1 = function(event) {
            var output = document.getElementById('FileUpload2');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

<script>

   $("#addads_Modola  button").click(function(e)
   {
    e.preventDefault();
       var fd = new FormData();
        var files = $('#file')[0].files;
         url=$("#addads_Modola form").attr('action');
        if(files.length > 0 ){
            
            fd.append('file',files[0]);
            $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: '{{route("add_ads")}}',
               type: 'post',
               data:fd,  
               contentType: false,
               processData: false,
               success: function(response){
                  if(response.hasOwnProperty('success')){
                    location.reload(true);
               }
                  else{
                     alert('file not uploaded');
                  }
               },
            });
         }
         else{
            alert("Please select a file.");
         }
       
        
     
   
   });
   //end add service
  $("#editModolad_AdsSlideShow button").click(function(e){
    e.preventDefault();
      if($(this).attr('type')==='edit')
      {
           
        var fd = new FormData();
        var files = $('#editModolad_AdsSlideShow form #file')[0].files;
        var status=$("#editModolad_AdsSlideShow form input[name='status']").prop('checked')?1:0;
        var Adsid=$("#editModolad_AdsSlideShow form input[name='Ads_id']").val();
        var oldimage=$("#editModolad_AdsSlideShow form input[name='oldimagepath']").val();
        fd.append('id',Adsid);
        fd.append('status',status);
        fd.append('oldimage',oldimage);

        if(files.length > 0 )
        {
            
            fd.append('file',files[0]);
        }
            $.ajax({
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               url: '{{route("update_ads")}}',
               type: 'post',
               data:fd,  
               contentType: false,
               processData: false,
               success: function(response){
                //    console.log(response);
                //    return;
                  if(response.hasOwnProperty('success')){
                    location.reload(true);
               }
                //   else{
                //      alert('file not uploaded');
                //   }
               },
            });
      


      }
  });
  
  //onedit show modola
  $("#editModolad_AdsSlideShow").on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget) //Button that triggered the modal
    var getHref = button.data('href'); //get button href
        $.ajax({
            url:getHref,
        }).done(function(data)
            {
               console.log(data);
            $("#editModolad_AdsSlideShow form img[name='ads_photo']").attr("src",data['imageurl']); 
            $("#editModolad_AdsSlideShow form input[name='Ads_id']").val(data['id']);
            $("#editModolad_AdsSlideShow form input[name='oldimagepath']").val(data['oldimage']);

            
            if(data['status']=='enabled')
            {
                $("#editModolad_AdsSlideShow form input[name='status']").prop('checked',true);
            }  
            else{
                $("#editModolad_AdsSlideShow form input[name='status']").prop('checked',false);
            }
        });
    });

    $("#deleteModola_AdsSlideShow").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_AdsSlideShow/"+id;
           console.log( delete_url);
           });

 $("#deleteModola_AdsSlideShow .adsslideshow-btn-del").click(function()
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
