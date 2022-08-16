<div class="modal fade" id="addpolicy_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('returnploicy_trans.add_policy') }}
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
                        <form action="{{route('addpolicy')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('returnploicy_trans.ploicy_name_ar') }}
                                    :</label>
                                <textarea class="form-control" name="name_ar" id="exampleFormControlTextarea1"
                                          rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('returnploicy_trans.ploicy_name_en') }}
                                    :</label>
                                <textarea class="form-control" name="name_en" id="exampleFormControlTextarea1"
                                          rows="3"></textarea>
                            </div>
                            <div class="form-group">
                               
                            </div>
                            <br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('returnploicy_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('returnploicy_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>