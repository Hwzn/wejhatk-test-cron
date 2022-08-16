 <!-- edit_modal_ -->
 <div class="modal fade" id="editagency_modola" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ trans('AgencyType_trans.edit_agency') }}
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
                                                <form action="{{route('update_agency')}}" method="POST">
                                                   @csrf
                                                   

                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="exampleFormControlTextarea1">{{ trans('AgencyType_trans.AgencyType') }}
                                                                                    :</label>
                                                                                <input class="form-control" name="name_ar" />
                                                                                <input class="form-control" name="agency_typeid" type="hidden" />
                                                                            </div>
                                                                            <br><br>
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="exampleFormControlTextarea1">{{ trans('AgencyType_trans.AgencyType') }}
                                                                                    :</label>
                                                                                <input class="form-control" name="name_en" />
                                                                            </div>
                                                                            <hr>
                                                                            <div class="col-6">
                                                                               <label for="">{{ trans('AgencyType_trans.status') }}</label>
                                                                             <input type="checkbox" name="status" ></input>
                                                                             </div>
                                                                            <br><br>
                                                                          
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">{{  trans('AgencyType_trans.Close') }}</button>
                                                                        <button  type="edit"
                                                                                class="btn btn-success">{{ trans('AgencyType_trans.submit') }}</button>
                                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>



        <!-- edit_modal_ -->