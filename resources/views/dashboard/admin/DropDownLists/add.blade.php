<div class="modal fade" id="addDropDownLists_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('DropDownLists_trans.Add_DropDownList') }}
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
                        <form action="{{route('addDropDownLists')}}" method="POST">
                            @csrf
                          
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('DropDownLists_trans.name') }}
                                    :</label>
                                <input class="form-control" name="name" />
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('DropDownLists_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('DropDownLists_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>