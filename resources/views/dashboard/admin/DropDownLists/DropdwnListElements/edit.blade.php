 <!-- edit_modal_Grade -->
 <div class="modal fade" id="edit{{ $dropdownlist->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                id="exampleModalLabel">
                                                {{ trans('serviceattribute_trans.Edit') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- add_form  -->
                                            <form action="{{route('updates_attributeelement')}}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                    <div class="col">
                                            <label for="Name_en"
                                                class="mr-sm-2">{{ trans('DropDownLists_trans.ChooseDropDownlist') }}
                                                :</label>

                                            <div class="box">
                                                <select class="fancyselect" name="dropdown_id">
                                                   <option value="{{$dropdownlist->selecttype_id}}">{{$dropdownlist->selecttype_elements->name}}</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col">
                                            <label for="Name"
                                                class="mr-sm-2">{{ trans('DropDownLists_trans.attribute_value_ar') }}
                                                :</label>
                                            <input class="form-control" type="text" name="attribute_dropdown_ar" value="{{$dropdownlist->getTranslation('name', 'ar')}}"  />
                                            <input class="form-control" type="hidden" name="dropdownlist_id" value="{{$dropdownlist->id}}"  />

                                        </div>
                                        <div class="col">
                                            <label for="Name"
                                                class="mr-sm-2">{{ trans('DropDownLists_trans.attribute_value_en') }}
                                                :</label>
                                            <input class="form-control" type="text" name="attribute_dropdown_en" value="{{$dropdownlist->getTranslation('name', 'en')}}"  />

                                        </div>
                                        </div>


                              
                                      
                                                   
                                         <div class="row">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ trans('serviceattribute_trans.Close') }}</button>
                                                        <button type="submit"
                                                                class="btn btn-success">{{ trans('serviceattribute_trans.Edit') }}</button>
                                                    </div>
                                                    </div> 
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>