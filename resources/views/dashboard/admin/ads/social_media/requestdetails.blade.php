<div class="modal fade" id="requestdetail_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('ad_trans.Ads_SocialMediaDetails') }}
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
                        <form action="{{route('updaterequest_details')}}" Method="post">
                            @csrf
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('ads_trans.ads_description') }}
                                    :</label>
                                    <input class="form-control" name="request_id" type="hidden" />
                                    <input class="form-control" name="tripagent_id" type="hidden" />

                                <textarea class="form-control" name="descripation" id="exampleFormControlTextarea1"
                                          rows="3" readonly></textarea>
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('ads_trans.addational_information') }}
                                    :</label>
                                <textarea class="form-control" name="addational_information" id="exampleFormControlTextarea1"
                                          rows="3" readonly></textarea>
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('ad_trans.admin_reply') }}
                                    :</label>
                                <textarea class="form-control" name="admin_reply" id="exampleFormControlTextarea1"
                                          rows="6" ></textarea>
                                          <label
                                    for="exampleFormControlTextarea1">{{ trans('ads_trans.actual_price') }}
                                    :</label>
                                <input class="form-control" name="admin_price" id="exampleFormControlTextarea1" />
                                                   
                            </div>
                            <div class="form-group"  id="box">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('ads_trans.change_status') }}
                                    :</label>
                                    <div class="box">
                                                <select  class="fancyselect" name="status">
                                                   <option value="pending">pending</option>
                                                   <option value="confirmed">confirmed</option>
                                                   <option value="refused">refused</option>
                                                </select>
                                    </div>
                            </div>
                            <br><br>

                            
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('ads_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success" name="add" id="savereplay">{{ trans('ads_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
        