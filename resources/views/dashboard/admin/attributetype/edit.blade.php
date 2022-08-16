 <!-- edit_modal_ -->
 <div class="modal fade" id="editModolad_attributetype" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ trans('attributetype_trans.edit_attributetype') }}
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
                                                <form action="{{route('updateattribute_type')}}" method="POST">
                                                   @csrf
                                                    <div class="row">
                                                <div class="col">
                                                    <label for="Name"
                                                        class="mr-sm-2">{{ trans('attributetype_trans.attrubite_type') }}
                                                        :</label>
                                                    <input id="Name" type="text" name="Name" class="form-control Addservice_Nameddar">
                                                    <input id="Namerr" type="hidden" name="attributetype_id" class="form-control">

                                                </div>
                                              
                                               
                                            </div>
                                           
                                                                            <br><br>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">{{  trans('Service_trans.Close') }}</button>
                                                                        <button  type="edit"
                                                                                class="btn btn-success">{{ trans('Service_trans.submit') }}</button>
                                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>



        <!-- edit_modal_ -->