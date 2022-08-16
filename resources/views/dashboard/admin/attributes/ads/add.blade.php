<div class="modal fade" id="addadsattribute_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('attribute_trans.add_attribute') }}
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
                        <form action="{{route('add_adsattribute')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('attribute_trans.AttributeName_ar') }}
                                        :</label>
                                    <input id="Name" type="text" name="Name" class="form-control Addservice_Namear">
                                </div>
                                <div class="col">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('attribute_trans.AttributeName_en') }}
                                        :</label>
                                    <input type="text" class="form-control"   name="Name_en"
                                      class="form-control Addservice_Nameen">
                                      @error('Name_en')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col">
                                                    <label
                                                    for="exampleFormControlTextarea1">{{ trans('ads_trans.Attribute_Type') }}
                                                    :</label>
                                                        <select class="custom-select my-1 mr-sm-2" name="Attribute_Type">
                                                          @foreach($attruib_type as $attruibtype)
                                                                <option value="{{$attruibtype->id}}">{{$attruibtype->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                    
                            </div>
                            <br><br>
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