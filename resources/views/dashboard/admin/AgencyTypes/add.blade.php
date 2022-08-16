<div class="modal fade" id="addAgency_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('AgencyType_trans.Add_AgencyType') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                         <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                         </div>
                        <!-- add_form -->
                        <form action="{{route('addAgencyType')}}" method="POST">
                            @csrf
                          
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('AgencyType_trans.AgencyType_ar') }}
                                    :</label>
                                <input class="form-control" name="AgencyType_ar" />
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('AgencyType_trans.AgencyType_en') }}
                                    :</label>
                                <input class="form-control" name="AgencyType_en" />
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('AgencyType_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('AgencyType_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>