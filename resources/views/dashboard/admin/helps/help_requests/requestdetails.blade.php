<div class="modal fade" id="requestdetail_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('helps_trans.request_details') }}
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
                        <form action="{{route('updaterequesthelp_details')}}" Method="post">
                            @csrf
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('helps_trans.request_details') }}
                                    :</label>
                                    <input class="form-control" name="request_id" type="text" />
                                    <input class="form-control" name="user_id" type="hidden" />
                                    <input class="form-control" name="tripagent_id" type="hidden" />
                                    <input class="form-control" name="tourguide_id" type="hidden" />
                                    <input class="form-control" name="ticket_num" type="hidden" />

                                    
                                <textarea class="form-control" name="usermessage" id="exampleFormControlTextarea1"
                                          rows="3" readonly></textarea>
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('helps_trans.admin_reply') }}
                                    :</label>
                                <textarea class="form-control" name="admin_reply" id="exampleFormControlTextarea1"
                                          rows="6" ></textarea>
                            </div>
                            <br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('helps_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success" name="add" id="savereplay">{{ trans('helps_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
        