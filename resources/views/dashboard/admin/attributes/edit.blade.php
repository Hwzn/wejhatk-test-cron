 <!-- edit_modal_ -->
 <div class="modal fade" id="editModolad_attribute" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ trans('attribute_trans.Edit_Attribute') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- add_form -->
                                                <div class="alert alert-danger print-error-msg" style="display:none">
                                                     <ul></ul>
                                                  </div>
                                                <form action="{{route('updateattribute')}}" method="POST">
                                                   @csrf
                                                    <div class="row">
                                                <div class="col">
                                                    <label for="Name"
                                                        class="mr-sm-2">{{ trans('attribute_trans.AttributeName_ar') }}
                                                        :</label>
                                                    <input id="Name" type="text" name="Name" class="form-control Addservice_Nameddar">
                                                    <input  type="hidden" name="attribute_id" class="form-control">

                                                    
                                                </div>
                                                <div class="col">
                                                    <label for="Name_en"
                                                        class="mr-sm-2">{{ trans('attribute_trans.AttributeName_en') }}
                                                        :</label>
                                                    <input type="text" class="form-control"   name="Name_en"
                                                    class="form-control">
                                                </div>
                                               
                                            </div>
                                            <div class="form-row">
                                                    <div class="form-group col">
                                                    <label
                                                    for="exampleFormControlTextarea1">{{ trans('attribute_trans.Attribute_Type') }}
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
                                                                                data-dismiss="modal">{{  trans('attribute_trans.Close') }}</button>
                                                                        <button  type="edit"
                                                                                class="btn btn-success">{{ trans('attribute_trans.submit') }}</button>
                                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>



        <!-- edit_modal_ -->