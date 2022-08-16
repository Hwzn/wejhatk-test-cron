@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('ContactUs_trans.Contact_us')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('ContactUs_trans.Message_list')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('ContactUs_trans.Contact_us')}}</li>
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
                                <th>{{trans('ContactUs_trans.name')}}</th>
                                 <th></th>
                                <th>{{trans('ContactUs_trans.phone')}}</th>
                                <th>{{trans('ContactUs_trans.message')}}</th>
                                <th>{{trans('ContactUs_trans.date_message')}}</th>
                                <th>{{trans('ContactUs_trans.Proccess')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($contact_message as $message)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>
                                    @if($message->type=='user')
                                    <label class="badge badge-success">user</label>
                                    @elseif($message->type=='tripagent')
                                    <label class="badge badge-danger">tripagent</label>
                                    @elseif($message->type=='tourguide')
                                    <label class="badge badge-primary">tourguide</label>
                                    @else
                                    <label class="badge badge-danger">no-user</label>
                                    @endif
                                    </td>
                                    <td>{{ $message->phone }}</td>
                                    <td>{!! \Str::Limit($message->message,200) !!}</td>
                                    <td>{{ $message->created_at }}</td>
                                     <td>
                                     <a class="btn btn-info btn-sm" href="#" title="show message"
                                                   data-href="{{ route('showmessage',$message->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#showModolad_message">
                                                  <i style="color: #ffc107" class="far fa-eye"></i>
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
 @include('dashboard.admin.contactus.showmessage')

    </div>
    </div>
    <!-- row closed -->


    @endsection
@section('js')
<script>
  $("#showModolad_message").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href
// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
           
            $("#showModolad_message form input[name='name']").val(data.name);
            $("#showModolad_message form input[name='phone']").val(data.phone);
            $("#showModolad_message form textarea[name='message']").val(data.message);
            
        });
});


  
</script>
  
@endsection
