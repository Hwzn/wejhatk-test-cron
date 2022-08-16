@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('Currencies_trans.Currencies')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('Currencies_trans.Currencies')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('main_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('Currencies_trans.Currencies')}}</li>
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
                       data-target="#addCurrency_Modola">
                       {{ trans('Currencies_trans.add currency') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('Currencies_trans.currency')}}</th>
                                <th>{{trans('Currencies_trans.short currency')}}</th>
                                <th>{{trans('Currencies_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($currencies as $currency)
                                <tr>
                                
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $currency->name }}</td>
                                    <td>{{ $currency->short_name }}</td>
                                    <td>
                                       <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('edit_currency',$currency->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editCurrency_Modola">
                                                  <i class="fa fa-edit"></i>
                                           </a>   

                                         <a  class="btn btn-danger btn-sm" 
                                                 href="#" data-toggle="modal"  data-target="#deleteCurrency_Modola"
                                               delete-id="{{$currency->id}}">
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


      
 @include('dashboard.admin.currencies.add')
 @include('dashboard.admin.currencies.edit')
 @include('dashboard.admin.currencies.delete')


    </div>
    </div>
    <!-- row closed -->


@endsection
@section('js')
<script>
   $("#addCurrency_Modola  button,#editCurrency_Modola  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
       
         url=$("#addCurrency_Modola form").attr('action');
        
         data={
            name_ar:$("#addCurrency_Modola form input[name='name_ar']").val(),
            name_en:$("#addCurrency_Modola form input[name='name_en']").val(),

            shortname_ar:$("#addCurrency_Modola form input[name='shortname_ar']").val(),
            shortname_en:$("#addCurrency_Modola form input[name='shortname_en']").val(),
          };
        }
        if($(this).attr('type')==='edit')
       {
       
         url=$("#editCurrency_Modola form").attr('action');
         data={
             
            name_ar:$("#editCurrency_Modola form input[name='name_ar']").val(),
            name_en:$("#editCurrency_Modola form input[name='name_en']").val(),

            shortname_ar:$("#editCurrency_Modola form input[name='shortname_ar']").val(),
            shortname_en:$("#editCurrency_Modola form input[name='shortname_en']").val(),

            currency_id:$("#editCurrency_Modola form input[name='currency_id']").val(),
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
  $("#editCurrency_Modola").on('show.bs.modal', function(event) {

var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
          
            $("#editCurrency_Modola form input[name='name_ar']").val(data.name['ar']);
            $("#editCurrency_Modola form input[name='name_en']").val(data.name['en']);

            $("#editCurrency_Modola form input[name='shortname_ar']").val(data.short_name['ar']);
            $("#editCurrency_Modola form input[name='shortname_en']").val(data.short_name['en']);

            $("#editCurrency_Modola form input[name='currency_id']").val(data.id);
            
            
        });
});


   $("#deleteCurrency_Modola").on('show.bs.modal', function(event) {
           
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           delete_url="/admin/delete_currency/"+id;
           console.log( delete_url);
           });

 $("#deleteCurrency_Modola .currency-btn-del").click(function()
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
