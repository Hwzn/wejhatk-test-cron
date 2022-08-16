<div class="modal fade" id="addads_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('AdsSlideShow_trans.add_Ads') }}
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
                        <form action="{{route('add_ads')}}" id="imageUpload" method="POST">
                            @csrf
                          
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('AdsSlideShow_trans.ads_photo') }}
                                    :</label>
                                 <input type="file" name="ads_photo" id="file" accept="image/*" `onchange="loadFile(event)" class="form-control">
                                 <hr>
                                 <img style="width:400px;height:200px" id="output" />
                                 <hr>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('helps_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('helps_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
