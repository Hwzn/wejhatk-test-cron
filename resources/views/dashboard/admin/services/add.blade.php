<div class="modal fade" id="addservice_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('Service_trans.add_Service') }}
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
                        <form action="{{route('addservice')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('Service_trans.ServiceName_ar') }}
                                        :</label>
                                    <input id="Name" type="text" name="Name" class="form-control Addservice_Namear">
                                </div>
                                <div class="col">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('Service_trans.ServiceName_en') }}
                                        :</label>
                                    <input type="text" class="form-control"  id="addGrad_Name" name="Name_en"
                                      class="form-control Addservice_Nameen">
                                      @error('Name_en')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('Service_trans.Service_desc') }}
                                    :</label>
                                <textarea class="form-control" name="Notes" id="exampleFormControlTextarea1"
                                          rows="3"></textarea>
                            </div>
                            <br><br>
                            <hr>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('Service_trans.Service_desc') }}
                                    :</label>
                                <input type="file"  accept="image/*" name="service_file" id="file" onchange="loadFile(event)"/>
                                <img style="width: 50px;height:50px" id="imgservice" />
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