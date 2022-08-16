<div class="modal fade" id="addaboutus_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('Aboutus_trans.New_Define') }}
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
                        <form action="{{route('addaboutus')}}" method="POST">
                            @csrf
                          
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
                                data-dismiss="modal">{{  trans('Service_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('Service_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>