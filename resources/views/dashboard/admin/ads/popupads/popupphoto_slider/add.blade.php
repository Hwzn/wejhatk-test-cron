<div class="modal fade" id="addSliderPhoto_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('ads_trans.add_SliderPhoto') }}
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
                        <form action="{{route('add_photo')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                          
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('ads_trans.photo') }}
                                    :</label>
                                    <div class="col-md-12">
                                      <input type="file" name="photo" class="form-control"
                                      accept = 'image/*' id="file"  onchange="loadFile(event)" />
                                      <img style="width: 50px;height:50px;border:hidden" id="imgservice1" />
                                   </div>
                            </div>
                            <hr>
                           
                            <div class="form-group" class="col-md-6">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('ads_trans.expire_date') }}
                                    :</label>
                                    <input type="date" id="meeting-time"
                                        name="expired_at" value="<?php echo date('Y-m-d'); ?>">
                                       
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('ads_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('ads_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>