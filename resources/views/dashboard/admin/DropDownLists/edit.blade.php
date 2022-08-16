 <!-- edit_modal_ -->
 <div class="modal fade" id="editDropDownList_Modola" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ trans('DropDownLists_trans.edit_DropDownList') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- add_form -->
                                                <div class="alert alert-danger print-error-msg" style="display:none">
                                                     <ul></ul>
                                                  </div>
                                                <form action="{{route('update_DropDownList')}}" method="POST">
                                                   @csrf
                                                   
                                                   <input  type="hidden" name="select_typeid" class="form-control">

                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="exampleFormControlTextarea1">{{ trans('DropDownLists_trans.name') }}
                                                                                    :</label>
                                                                                <input class="form-control" name="name" />
                                                                            </div>
                                                                            <br><br>

                                                                          
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">{{  trans('DropDownLists_trans.Close') }}</button>
                                                                        <button  type="edit"
                                                                                class="btn btn-success">{{ trans('DropDownLists_trans.submit') }}</button>
                                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>



        <!-- edit_modal_ -->