@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('helps_trans.Requests_Help')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('helps_trans.Requests_Help')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('helps_trans.Requests_Help')}}</li>
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
                                <th>{{trans('helps_trans.ticket_number')}}</th>
                                <th>{{trans('helps_trans.user_name')}}</th>
                                <th></th>
                                <th>{{trans('helps_trans.help_type')}}</th>
                                <th>{{trans('helps_trans.status')}}</th>
                                <th>{{trans('helps_trans.Request_Date')}}</th>
                                <th>{{trans('helps_trans.request_photo')}}</th>
                                <th>{{trans('helps_trans.proccess')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $request->ticket_num }}</td>
                                    @if(!is_null($request->user_id))
                                     <td>{{ $request->users->name }}</td> 
                                    @elseif(!is_null($request->tripagent_id))
                                    <td>{{ $request->tripagents->name }}</td> 
                                    @elseif(!is_null($request->tourguide_id))
                                    <td>{{ $request->tourguides->name }}</td> 
                                    @else
                                     <td>announmace user</td>
                                    @endif
                                    @if(!is_null($request->user_id))
                                     <td>
                                     <label
                                         class="badge badge-success">User</label>
                                     </td> 
                                    @elseif(!is_null($request->tripagent_id))
                                    <td>
                                       <label
                                         class="badge badge-success">Tripagent</label>
                                    </td> 
                                    @elseif(!is_null($request->tourguide_id))
                                    <td>
                                       <label
                                         class="badge badge-success">Tourguide</label>
                                    </td> 
                                    @else
                                     <td>no_user</td>
                                    @endif
                                    <td>{{ $request->helps->name }}</td>
                                    <td>
                                       @if ($request->status === 'pending')
                                         <label
                                              class="badge badge-danger">{{ trans('helps_trans.Pending') }}</label>
                                          @else
                                          <label
                                              class="badge badge-success">{{ trans('helps_trans.Closed') }}</label>
                                     @endif

                                    </td>
                                    <td>{{ $request->created_at}}</td>
                                    <td>
                                    @if(!empty($request->request_photo))
                                       @if(!is_null($request->user_id))
                                          <a class="btn btn-outline-info btn-sm"
                                                           href="{{route('view_attachment',$request->request_photo)}}"
                                                        role="button"><i class="fas fa-download"></i>&nbsp; {{trans('helps_trans.View')}}</a>
                                       
                                         @elseif(!is_null($request->tripagent_id))
                                         <a class="btn btn-outline-info btn-sm"
                                                           href="{{route('viewtripagent_attachment',$request->request_photo)}}"
                                                        role="button"><i class="fas fa-download"></i>&nbsp; {{trans('helps_trans.View')}}</a>
                                                        @elseif(!is_null($request->tourguide_id))
                                         <a class="btn btn-outline-info btn-sm"
                                                           href="{{route('viewtourguide_attachment',$request->request_photo)}}"
                                                        role="button"><i class="fas fa-download"></i>&nbsp; {{trans('helps_trans.View')}}</a>

                                        @else

                                         @endif
                                      @endif
                                    </td>
                                   
                                    <td>
                                    <a class="btn btn-info btn-sm" href="#"  title="view problem > {{$request->ticket_num}}"
                                                  data-href="{{ route('requesthelpdetails',$request->id) }}"
                                                   request-id="{{$request->id}}" 
                                                   status="{{$request->status}}"
                                                   data-toggle="modal" 
                                                   data-target="#requestdetail_Modola">
                                                  <i class="far fa-eye"></i>
                                           </a>  
                                    </td>
                                </tr>

                              @endforeach
                              <div class="d-flex justify-content-center w-100 mb-5">
                              {!! $requests->render() !!}
                              </div>
                            </tbody>
                        </table>
               
                    </div>
                </div>
            </div>
 </div>


      

 @include('dashboard.admin.helps.help_requests.requestdetails')
    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#requestdetail_Modola  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
         url=$("#requestdetail_Modola form").attr('action');
        
         data={
            admin_reply:$("#requestdetail_Modola form textarea[name='admin_reply']").val(),
            request_id:$("#requestdetail_Modola form input[name='request_id']").val(),
            user_id:$("#requestdetail_Modola form input[name='user_id']").val(),
            tripagent_id:$("#requestdetail_Modola form input[name='tripagent_id']").val(),
            tourguide_id:$("#requestdetail_Modola form input[name='tourguide_id']").val(),
            ticket_num:$("#requestdetail_Modola form input[name='ticket_num']").val(),

           
        };
       
        }
      
         $.ajax({
           url:url,
           data:data,
           type:'POST',
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           
           success:function(data)
            {
            //    console.log(data);
            //    return;
                if(data.hasOwnProperty('success')){
                    location.reload(true);
               }else{
                   
                   printErrorMsg(data.error);
               }
            }
         });
     
   
   });
     //onedit show modola
  $("#requestdetail_Modola").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
           
            $("#requestdetail_Modola form textarea[name='usermessage']").val(data.request_details);
           // $("#requestdetail_Modola form textarea[name='admin_reply']").val(data.admin_reply);

     if(data.admin_reply==null)
       {
        $("#requestdetail_Modola form textarea[name='admin_reply']").val(null);
        $("#requestdetail_Modola form textarea[name='admin_reply']").prop('readonly',false);
       }
       else
       {
         $("#requestdetail_Modola form textarea[name='admin_reply']").val(data.admin_reply);
         $("#requestdetail_Modola form textarea[name='admin_reply']").prop('readonly',true);

       }
            if(data.user_id !==null)
            {
                $("#requestdetail_Modola form input[name='user_id']").val(data.user_id);
                $("#requestdetail_Modola form input[name='tripagent_id']").val(null);
                $("#requestdetail_Modola form input[name='tourguide_id']").val(null);
                
            }
            elseif(data.tripagent_id !==null)
            {
                $("#requestdetail_Modola form input[name='user_id']").val(null);
                $("#requestdetail_Modola form input[name='tripagent_id']").val(data.tripagent_id);
                $("#requestdetail_Modola form input[name='tourguide_id']").val(null);
            }
            elseif(data.tourguide_id !==null)
            {
                $("#requestdetail_Modola form input[name='user_id']").val(null);
                $("#requestdetail_Modola form input[name='tripagent_id']").val(null);
                $("#requestdetail_Modola form input[name='tourguide_id']").val(data.tourguide_id);
            }
    
            $("#requestdetail_Modola form input[name='ticket_num']").val(data.ticket_num);
            $("#requestdetail_Modola form input[name='admin_reply']").val(data.admin_reply);
            
            $("#requestdetail_Modola form input[name='request_id']").val(data.id);
            $("#requestdetail_Modola form input[name='request_status']").val(data.status);

           if(data.status=="pending")
            $("#savereplay").show();
            else
            $("#savereplay").hide();
            
            
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
