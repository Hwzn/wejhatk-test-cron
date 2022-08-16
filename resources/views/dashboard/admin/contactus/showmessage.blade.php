<div class="modal fade" id="showModolad_message" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('ContactUs_trans.show_message') }}
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
                        <form action="">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('ContactUs_trans.name') }}
                                        :</label>
                                    <input id="Name" type="text" name="name" readonly class="form-control Addservice_Namear">
                                    <input  type="hidden" name="contactus_id" class="form-control Addservice_Namear">

                                    
                                </div>
                                <div class="col">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('ContactUs_trans.phone') }}
                                        :</label>
                                    <input type="text" class="form-control"   name="phone" readonly
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
                                    for="exampleFormControlTextarea1">{{ trans('ContactUs_trans.message') }}
                                    :</label>
                                <textarea class="form-control" readonly name="message" id="exampleFormControlTextarea1"
                                          rows="6"></textarea>
                            </div>
                           
                            <br><br>
                    </div>
                   
                    </form>

                </div>
            </div>
        </div>
        