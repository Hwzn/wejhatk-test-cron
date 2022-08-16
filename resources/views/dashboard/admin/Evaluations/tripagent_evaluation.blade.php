@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('Evalutions_trans.Tripagents_Evaluation')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('Evalutions_trans.Tripagents_Evaluation')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('Evalutions_trans.Tripagents_Evaluation')}}</li>
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
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('Evalutions_trans.Tripagent_name')}}</th>
                                <th>{{trans('Evalutions_trans.User_name')}}</th>
                                <th>{{trans('Evalutions_trans.Evaluation')}}</th>
                                <th>{{trans('Evalutions_trans.created_at')}}</th>
                                <th>{{trans('Evalutions_trans.updated_at')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($star_rate as $star)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $star->name }}</td>
                                    <td>
                                      @if($star->photo !==null)
                                       <img  src="{{ URL::asset('assets/uploads/Profile/UserProfile/'.$star->photo) }}" width="15%" alt="">
                                      @else
                                      <img  src="{{ URL::asset('assets/uploads/Profile/UserProfile/defaultimage.jpg') }}" width="15%" alt="">
                                      @endif
                                      {{ $star->username }}

                                    </td>
                                  
                                    <td>
                                    @if($star->stars_rated==1)
                                      <img  src="{{ URL::asset('assets/uploads/star/1.jpg') }}" width="8%" alt="">
                                    @elseif($star->stars_rated==2)
                                      <img src="{{ URL::asset('assets/uploads/star/2.jpg') }}" width="16%" alt="">
                                      @elseif($star->stars_rated==3)
                                      <img src="{{ URL::asset('assets/uploads/star/3.jpg') }}" width="30%" alt="">
                                      @elseif($star->stars_rated==4)
                                      <img src="{{ URL::asset('assets/uploads/star/4.jpg') }}" width="40%" alt="">
                                      @elseif($star->stars_rated==5)
                                      <img src="{{ URL::asset('assets/uploads/star/5.jpg') }}" width="40%" alt="">
                                      @else
                                        {{ $star->stars_rated }}
                                      @endif
                                    </td>

                                    <td>{{ $star->created_at }}</td>
                                    <td>{{ $star->updated_at }}</td>

                                  
                                  
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
               
                    </div>
                </div>
            </div>
 </div>

 @include('dashboard.admin.Activited_Accounts.tourguides.edit')

    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#tourguide_modola  button").click(function(e)
   {
    e.preventDefault();
    
        if($(this).attr('type')==='edit')
       {
       
         url=$("#tourguide_modola form").attr('action');
         data={
           name:$("#tourguide_modola form input[name='name']").val(),
           tourguide_id:$("#tourguide_modola form input[name='tourguide_id']").val(),
           status:$("#tourguide_modola form input[name='status']").prop('checked')?1:0

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
  $("#tourguide_modola").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href
// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
            $("#tourguide_modola form input[name='name']").val(data.name);
            $("#tourguide_modola form input[name='tourguide_id']").val(data.id);
        
            if(data.status=="active")
            $("#tourguide_modola form input[name='status']").prop('checked',true);
            else
                $("#tourguide_modola form input[name='status']").prop('checked',false);
          
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