<div class="modal fade" id="editModolad_MethodCommunicate" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('TimeCommunicate_trans.edit_method communicate') }}
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
                        <form action="{{route('update_timecommunicate')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('TimeCommunicate_trans.preferred time') }}
                                        :</label>
                                    <input id="Name" type="text" name="name" class="form-control Addservice_Namear">
                                    <input  type="hidden" name="timecommunicate_id" class="form-control Addcar_type">

                                    
                                </div>
                             
                                
                            </div>
                           
                            <div class="form-group">
                               
                            </div>
                            <br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('TimeCommunicate_trans.Close') }}</button>
                        <button  type="edit"
                                class="btn btn-success">{{ trans('TimeCommunicate_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>