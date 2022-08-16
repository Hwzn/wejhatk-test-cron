 <!-- edit_modal_ -->
 <div class="modal fade" id="edithelp_Modola" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ trans('helps_trans.edit_help') }}
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
                                                <form action="{{route('update_help')}}" method="POST">
                                                   @csrf
                                                   
                                                   <input  type="hidden" name="help_id" class="form-control">

                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="exampleFormControlTextarea1">{{ trans('helps_trans.ar_name') }}
                                                                                    :</label>
                                                                                <input class="form-control" name="name_ar" />
                                                                            </div>
                                                                            <br><br>

                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="exampleFormControlTextarea1">{{ trans('helps_trans.en_name') }}
                                                                                    :</label>
                                                                                <input class="form-control" name="name_en" />
                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">{{  trans('helps_trans.Close') }}</button>
                                                                        <button  type="edit"
                                                                                class="btn btn-success">{{ trans('helps_trans.submit') }}</button>
                                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>



        <!-- edit_modal_ -->