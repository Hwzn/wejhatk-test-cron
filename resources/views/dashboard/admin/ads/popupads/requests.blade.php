@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('ads_trans.Popup_ads')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('ads_trans.Popup_ads')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('ads_trans.Popup_ads')}}</li>
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
                                <th>{{trans('ads_trans.agency_name')}}</th>
                                <th>{{trans('ads_trans.phone')}}</th>
                                <th>{{trans('ads_trans.email')}}</th>
                                <th>{{trans('ads_trans.ads_date')}}</th>
                                <th>{{trans('ads_trans.campaign_duration')}}</th>
                                <th>{{trans('ads_trans.agency_logo')}}</th>
                                <th>{{trans('ads_trans.actual_price')}}</th>
                                <th>{{trans('ads_trans.status')}}</th>
                                <th>{{trans('ads_trans.created_at')}}</th>
                                <th>{{trans('ads_trans.photo')}}</th>
                                <th>{{trans('ads_trans.proccess')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($ads as $ad)
                                <tr>
                                
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $ad->agency_name }}</td>
                                    <td>{{ $ad->phone }}</td> 
                                    <td>{{ $ad->email }}</td> 
                                    <td>{{ $ad->ads_date }}</td> 
                                    <td>{{ $ad->campaign_duration }}</td> 
                                    <td>
                                      @if($ad->agency_logo==1)
                                         @lang('ads_trans.yes')
                                      @else
                                        @lang('ads_trans.no')
                                       @endif
                                    </td> 
                                    <td>{{ $ad->actual_price }}</td> 
                                    <td>
                                       @if ($ad->status === 'pending')
                                         <label
                                              class="badge badge-danger">{{ trans('ads_trans.Pending') }}</label>
                                          @else
                                          <label
                                              class="badge badge-success">{{ trans('ads_trans.Closed') }}</label>
                                      @endif

                                    </td>
                                    <td>{{ $ad->created_at}}</td>
                                    <td>
                                    @if(!empty($ad->photo))
                                       @if(!is_null($ad->photo))
                                          <a class="btn btn-outline-info btn-sm"
                                                           href="{{route('view_popattachment',$ad->photo)}}"
                                                        role="button"><i class="fas fa-download"></i>&nbsp; {{trans('ads_trans.View')}}</a>
                                        
                                        @else

                                         @endif
                                      @endif
                                    </td>
                                   
                                    <td>
                                    <a class="btn btn-info btn-sm" href="#"  title="view problem > {{$ad->id}}"
                                                  data-href="{{route('showrequestad_popdetails',$ad->id)}}"
                                                   ad-id="{{$ad->id}}" 
                                                   data-toggle="modal" 
                                                   data-target="#requestdetail_Modola">
                                                  <i class="far fa-eye"></i>
                                           </a>  
                                    </td>
                                </tr>

                              @endforeach
                              <div class="d-flex justify-content-center w-100 mb-5">
                              </div>
                            </tbody>
                        </table>
               
                    </div>
                </div>
            </div>
 </div>

 @include('dashboard.admin.ads.popupads.requestdetails')

      <!-- include-->

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
            actual_price:$("#requestdetail_Modola form input[name='admin_price']").val(),
            ads_id:$("#requestdetail_Modola form input[name='request_id']").val(),
            status:$("#requestdetail_Modola form select[name='status']").val(),
            tripagent_id:$("#requestdetail_Modola form input[name='tripagent_id']").val(),

            
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
           
            $("#requestdetail_Modola form input[name='request_id']").val(data.id);
            $("#requestdetail_Modola form input[name='tripagent_id']").val(data.tripagent_id);

            
     if(data.admin_reply==null)
       {
        $("#requestdetail_Modola form textarea[name='admin_reply']").val(null);
        $("#requestdetail_Modola form textarea[name='admin_reply']").prop('readonly',false);
        $("#requestdetail_Modola form input[name='admin_price']").val(null);
        $("#requestdetail_Modola form input[name='admin_price']").prop('readonly',false);
       }
       else
       {
         $("#requestdetail_Modola form textarea[name='admin_reply']").val(data.admin_reply);
         $("#requestdetail_Modola form textarea[name='admin_reply']").prop('readonly',true);
         $("#requestdetail_Modola form input[name='admin_price']").val(data.actual_price);
        $("#requestdetail_Modola form input[name='admin_price']").prop('readonly',true);
       }
           
    
            

           if(data.status=="pending")
           {
            $("#box").show();
            $("#savereplay").show();
           }
          
            else
            {
             $("#box").hide();
               $("#savereplay").hide();
            }
           

            
            
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
