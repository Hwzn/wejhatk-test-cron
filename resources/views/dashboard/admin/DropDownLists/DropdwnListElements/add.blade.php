<!-- add_modal_class -->
<div class="modal fade" id="addelments_selectlistModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('DropDownLists_trans.add_attribute') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                         </div>
                <form class=" row mb-30" action="{{route('storedropdownlist_elements')}}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="repeater">
                            <div id="List_ServiceAttrbites" data-repeater-list="List_ServiceAttrbiteselemnt">
                                <div data-repeater-item>

                                    <div class="row">
                                      <div class="col">
                                            <label for="Name_en"
                                                class="mr-sm-2">{{ trans('DropDownLists_trans.ChooseDropDownlist') }}
                                                :</label>

                                            <div class="box">
                                                <select class="fancyselect" name="dropdown_id">
                                                    @foreach ($dropdownList_menus as $dropdown)
                                                        <option value="{{ $dropdown->id }}">{{ $dropdown->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col">
                                            <label for="Name"
                                                class="mr-sm-2">{{ trans('DropDownLists_trans.Dropdownlist_elements_ar') }}
                                                :</label>
                                            <input class="form-control" type="text" name="attribute_values_ar"  />
                                        </div>
                                        <div class="col">
                                            <label for="Name"
                                                class="mr-sm-2">{{ trans('DropDownLists_trans.Dropdownlist_elements_en') }}
                                                :</label>
                                            <input class="form-control" type="text" name="attribute_values_en"  />
                                        </div>
                                   
                                    </div>
                                </div>
                          </div>
                            <div class="row mt-20">
                                <div class="col-12">
                                    <input class="button" data-repeater-create type="button" value="{{ trans('DropDownLists_trans.add_record') }}"/>
                                </div>
                                <br/>

                            </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('DropDownLists_trans.Close') }}</button>
                                <button type="submit"
                                    class="btn btn-success">{{ trans('DropDownLists_trans.submit') }}</button>
                            </div>
                            

                        </div>
                    </div>
                </form>
            </div>


        </div>

    </div>