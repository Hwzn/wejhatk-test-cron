 <!-- edit_modal_ -->
 <div class="modal fade" id="editModolad_aboutus" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ trans('Aboutus_trans.edit_define') }}
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
                                                <form action="{{route('update_aboutus')}}" method="POST">
                                                   @csrf
                                                   
                                                   <input  type="hidden" name="aboutus_id" class="form-control">

                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="exampleFormControlTextarea1">{{ trans('Aboutus_trans.ar_desc') }}
                                                                                    :</label>
                                                                                <textarea class="form-control" name="desc_ar" id="exampleFormControlTextarea1"
                                                                                        rows="3"></textarea>
                                                                            </div>
                                                                            <br><br>

                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="exampleFormControlTextarea1">{{ trans('Aboutus_trans.en_desc') }}
                                                                                    :</label>
                                                                                <textarea class="form-control" name="desc_en" id="exampleFormControlTextarea1"
                                                                                        rows="3"></textarea>
                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">{{  trans('Aboutus_trans.Close') }}</button>
                                                                        <button  type="edit"
                                                                                class="btn btn-success">{{ trans('Aboutus_trans.submit') }}</button>
                                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>



        <!-- edit_modal_ -->