@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
    {{trans('packages_trans.Packages')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('packages_trans.Packages')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('packages_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('packages_trans.Packages')}}</li>
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
                       data-target="#addpackage_Modola">
                       {{ trans('packages_trans.New_Package') }}
                     </a>
                    <br><br>
                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                               data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('packages_trans.package_name')}}</th>
                                <th>{{trans('packages_trans.currency')}}</th>
                                <th>{{trans('packages_trans.price')}}</th>
                                <th>{{trans('packages_trans.days')}}</th> 
                                <th>{{trans('packages_trans.persons')}}</th>
                                <th>{{trans('packages_trans.status')}}</th>
                                <th>{{trans('packages_trans.Processes')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($Packages as $Package)
                                <tr>
                                  
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $Package->destination }}</td>
                                    <td>{{ $Package->currency->name }}</td>
                                    <td>{{ $Package->price }}</td>
                                    <td>{{ $Package->days }}</td>
                                    <td>{{ $Package->person_num }}</td>
                                    <td>
                                    @if($Package->status=='active')
                                    <label class="badge badge-success">{{ $Package->status }}</label>
                                    @else
                                    <label class="badge badge-danger">{{ $Package->status }}</label>
                                    @endif
                                    </td>
                                    <td>
                                          
                                      <a class="btn btn-info btn-sm" href="#" 
                                                   data-href="{{ route('edit_package',$Package->id) }}" 
                                                   data-toggle="modal" 
                                                   data-target="#editModolad_Package">
                                                  <i class="fa fa-edit"></i>
                                           </a>  
                                          
                                       <a  class="btn btn-danger btn-sm" 
                                                 href="#" data-toggle="modal"  data-target="#deleteModola_Package"
                                                 delete-id="{{$Package->id}}"
                                                 paackage_name="{{$Package->destination}}">
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
      
        @include('dashboard.admin.packages.add')

    </div>
    @include('dashboard.admin.packages.delete')
    @include('dashboard.admin.packages.edit')

    </div>
    <!-- row closed -->


@endsection
@section('js')

<script>
        var loadFile = function(event) {
            var output = document.getElementById('imgservice');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

<script>
        var loadFile1 = function(event) {
            var output = document.getElementById('img_service');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
<script>

$("#addpackage_Modola  button,#editModolad_Package  button").click(function(e)
   {
    e.preventDefault();
     if($(this).attr('type')==='add')
       {
      //  var $check = $("#addpackage_Modola form input[name='status']").val();
     
         url=$("#addpackage_Modola form").attr('action');
        
         data={
            destnation_ar:$("#addpackage_Modola form input[name='destnation_ar']").val(),
            destnation_en:$("#addpackage_Modola form input[name='destnation_en']").val(),
            currency_id:$("#addpackage_Modola form select[name='currency_id']").val(),
            price:$("#addpackage_Modola form input[name='price']").val(),
            person_num_ar:$("#addpackage_Modola form input[name='personnum_ar']").val(),
            person_num_en:$("#addpackage_Modola form input[name='personnum_en']").val(),

            days:$("#addpackage_Modola form input[name='days']").val(),
            
            packagedesc_ar:$("#addpackage_Modola form textarea[name='packagedesc_ar']").val(),
            packagedesc_en:$("#addpackage_Modola form textarea[name='packagedesc_en']").val(),

            packagecontain_ar:$("#addpackage_Modola form textarea[name='packagecontain_ar']").val(),
            packagecontain_en:$("#addpackage_Modola form textarea[name='packagecontain_en']").val(),

            conditions_ar:$("#addpackage_Modola form textarea[name='conditions_ar']").val(),
            conditions_en:$("#addpackage_Modola form textarea[name='conditions_en']").val(),

            cancelconditions_ar:$("#addpackage_Modola form textarea[name='cancelconditions_ar']").val(),
            cancelconditions_en:$("#addpackage_Modola form textarea[name='cancelconditions_en']").val(),

            notinclude_ar:$("#addpackage_Modola form textarea[name='notinclude_ar']").val(),
            notinclude_en:$("#addpackage_Modola form textarea[name='notinclude_en']").val(),

            policy_id:$("#addpackage_Modola form select[name='policy_id']").val(),

            

          };
        //   console.log(data);
        //   return;
        }
        if($(this).attr('type')==='edit')
       {
          
         url=$("#editModolad_Package form").attr('action');
         data={
             
            destnation_ar:$("#editModolad_Package form input[name='destnation_ar']").val(),
            destnation_en:$("#editModolad_Package form input[name='destnation_en']").val(),
            currency_id:$("#editModolad_Package form select[name='currencies_id']").val(),
            price:$("#editModolad_Package form input[name='price']").val(),
            person_num_ar:$("#editModolad_Package form input[name='personnum_ar']").val(),
            person_num_en:$("#editModolad_Package form input[name='personnum_en']").val(),

            days:$("#editModolad_Package form input[name='days']").val(),
            
            packagedesc_ar:$("#editModolad_Package form textarea[name='packagedesc_ar']").val(),
            packagedesc_en:$("#editModolad_Package form textarea[name='packagedesc_en']").val(),

            packagecontain_ar:$("#editModolad_Package form textarea[name='packagecontain_ar']").val(),
            packagecontain_en:$("#editModolad_Package form textarea[name='packagecontain_en']").val(),

            conditions_ar:$("#editModolad_Package form textarea[name='conditions_ar']").val(),
            conditions_en:$("#editModolad_Package form textarea[name='conditions_en']").val(),

            cancelconditions_ar:$("#editModolad_Package form textarea[name='cancelconditions_ar']").val(),
            cancelconditions_en:$("#editModolad_Package form textarea[name='cancelconditions_en']").val(),
           
            notinclude_ar:$("#editModolad_Package form textarea[name='notinclude_ar']").val(),
            notinclude_en:$("#editModolad_Package form textarea[name='notinclude_en']").val(),
     
            policy_id:$("#editModolad_Package form select[name='policy_id']").val(),

            package_id:$("#editModolad_Package form input[name='package_id']").val(),
            status:$("#editModolad_Package form input[name='status']").prop('checked')?1:0
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
  $("#editModolad_Package").on('show.bs.modal', function(event) {
var button = $(event.relatedTarget) //Button that triggered the modal
var getHref = button.data('href'); //get button href

// var update_url="http://127.0.0.1:8000/admin/update_service/";
// $('#editModolad_service form').attr('action',update_url);

    $.ajax({
        url:getHref,
    }).done(function(data)
        {
          $("#editModolad_Package form input[name='destnation_ar']").val(data.destination['ar']);
            $("#editModolad_Package form input[name='destnation_en']").val(data.destination['en']);
           
           
            $("#editModolad_Package form input[name='price']").val(data.price);
            $("#editModolad_Package form input[name='personnum_ar']").val(data.person_num['ar']);
            $("#editModolad_Package form input[name='personnum_en']").val(data.person_num['en']);
            $("#editModolad_Package form input[name='days']").val(data.days);
            $("#editModolad_Package form input[name='package_id']").val(data.id);

            
            $("#editModolad_Package form textarea[name='packagedesc_ar']").val(data.package_desc['ar']);
            $("#editModolad_Package form textarea[name='packagedesc_en']").val(data.package_desc['en']);

            $("#editModolad_Package form textarea[name='packagecontain_ar']").val(data.package_contain['ar']);
            $("#editModolad_Package form textarea[name='packagecontain_en']").val(data.package_contain['en']);

            $("#editModolad_Package form textarea[name='conditions_ar']").val(data.conditions['ar']);
            $("#editModolad_Package form textarea[name='conditions_en']").val(data.conditions['ar']);

            $("#editModolad_Package form textarea[name='cancelconditions_ar']").val(data.cancel_conditions['ar']);
            $("#editModolad_Package form textarea[name='cancelconditions_en']").val(data.cancel_conditions['ar']);
           
            $("#editModolad_Package form select[name='currencies_id']").val(data.currency_id);
            $("#editModolad_Package form select[name='currencies_id']").val(data.currency_id).change();

            $("#editModolad_Package form textarea[name='notinclude_ar']").val(data.package_notinclude['ar']);
            $("#editModolad_Package form textarea[name='notinclude_en']").val(data.package_notinclude['ar']);
           
            if(data.status=="active")
            $("#editModolad_Package form input[name='status']").prop('checked',true);
            else
                $("#editModolad_Package form input[name='status']").prop('checked',false);
          
            
            
        });
});


  
    $("#deleteModola_Package").on('show.bs.modal', function(event) {
        
           var button = $(event.relatedTarget) //Button that triggered the modal
           var id = button.attr('delete-id');
           var package_name=button.attr('paackage_name');
           $("#deleteModola_Package label[name='pakage_name']").text(package_name);
           delete_url="/admin/delete_package/"+id;
          console.log( delete_url);
           });
           
 $("#deleteModola_Package .package-btn-del").click(function()
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
