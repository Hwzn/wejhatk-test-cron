<div class="modal fade" id="editsocialModolad_ads" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('ads_trans.edit_scoailmedittype') }}
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
                        <form action="{{route('update_socialmediatype')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('ads_trans.socialname_ar') }}
                                        :</label>
                                    <input id="Name" type="text" name="name_ar" class="form-control Addservice_Namear">
                                </div>
                                <div class="col-6">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('ads_trans.socialname_en') }}
                                        :</label>
                                    <input type="text" class="form-control"  id="addGrad_Name" name="name_en"
                                      class="form-control Addservice_Nameen">
                                      <input type="hidden" class="form-control"  id="addGrad_Name" name="ads_id"
                                        class="form-control">
                                </div>
                               
                            </div>
                          
                   <div class="row">
                    <div class="col-6">
                          <hr>
                          <label for="">{{ trans('ads_trans.status') }}</label>
                           <input type="checkbox" name="status" ></input>
                    </div>
                   </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('ads_trans.Close') }}</button>
                        <button  type="edit"
                                class="btn btn-success">{{ trans('ads_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>