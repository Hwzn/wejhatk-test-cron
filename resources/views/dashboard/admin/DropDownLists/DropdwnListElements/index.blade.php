@extends('dashboard.layouts.master')
@section('css')
@toastr_css
@section('title')
{{trans('DropDownLists_trans.Dropdownlist_elements')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('DropDownLists_trans.Dropdownlist_elements')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">{{trans('DropDownLists_trans.Home')}}</a></li>
                <li class="breadcrumb-item active">{{trans('DropDownLists_trans.Dropdownlist_elements')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

   
<!-- row -->
<div class="row">

<div class="col-xl-12 mb-30">
    <div class="card card-statistics h-100">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

         
            <a href="#" class="button x-small" role="button" aria-disabled="true"
                       data-toggle="modal" 
                       data-target="#addelments_selectlistModal">
                       {{ trans('DropDownLists_trans.adddropdown_listelements') }}
                     </a>
                     <button type="button"  class="button x-small" id="btn_delete_all">
                {{ trans('DropDownLists_trans.CheckBoxDeleteAll') }}
            </button>
           
            <br><br>

           <!-- form -->

            <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                    style="text-align: center">
                    <thead>
                        <tr>
                          <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                            <th>#</th>
                            <th>{{ trans('DropDownLists_trans.DropDownLists_List') }}</th>
                            <th>{{ trans('DropDownLists_trans.DropDownlist_values') }}</th>
                            <th>{{ trans('DropDownLists_trans.Proccess') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                   
                    
                       
                        @foreach ($dropdownlists as $dropdownlist)
                            <tr>
                               <td><input type="checkbox"  value="{{ $dropdownlist->id }}" class="box1" ></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dropdownlist->selecttype_elements->name }}</td>
                                <td>{{ $dropdownlist->name }}</td>
                                <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#edit{{ $dropdownlist->id }}"
                                        title="{{ trans('DropDownLists_trans.Edit') }}"><i class="fa fa-edit"></i></button>
                                        
                                   <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#delete{{ $dropdownlist->id }}"
                                        title="{{ trans('DropDownLists_trans.delete_row') }}{{$dropdownlist->id}}"><i
                                            class="fa fa-trash"></i></button>
                                 
                                </td>
                            </tr>

                           <!-- //edit delete -->
                           @include('dashboard.admin.DropDownLists.DropdwnListElements.delete')
                           @include('dashboard.admin.DropDownLists.DropdwnListElements.edit')


                        @endforeach
                </table>
            </div>
        

        </div>
    </div>
</div>
                           <!-- //add -->
                           @include('dashboard.admin.DropDownLists.DropdwnListElements.add')
                           @include('dashboard.admin.DropDownLists.DropdwnListElements.edit')


</div>
</div>
</div>

</div>



<!-- حذف مجموعة صفوف -->
  <!-- حذف مجموعة صفوف -->
  <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                {{ trans('serviceattribute_trans.Warning_Delete') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('delete_allelements') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    {{ trans('serviceattribute_trans.delete_some_rows') }}
                    <input class="text" type="text" id="delete_all_id" name="delete_all_id" value='' readonly>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('serviceattribute_trans.Close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('serviceattribute_trans.Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


 @endsection
@section('js')

<script type="text/javascript">
    $(function() {
        $("#btn_delete_all").click(function() {

            var selected = new Array();
            $("#datatable input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
            });
            if (selected.length > 0) {
                $('#delete_all').modal('show')
                $('input[id="delete_all_id"]').val(selected);
            }
        });
    });

   
</script>


 @toastr_js
 @toastr_render

   
@endsection
