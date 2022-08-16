<div class="modal fade" id="addattributetype_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('attributetype_trans.New_typeAttribute') }}
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
                        <form action="{{route('addattribute_type')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('attributetype_trans.attrubitetype_name') }}
                                        :</label>
                                    <input id="Name" type="text" name="Name" class="form-control Addservice_Namear">
                                </div>
                            </div>
                           
                            <br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('attributetype_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('attributetype_trans.Submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>