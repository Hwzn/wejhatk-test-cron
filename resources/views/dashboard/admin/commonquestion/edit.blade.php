<div class="modal fade" id="editModolad_question" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('CommonQuestions_trans.add_question') }}
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
                        <form action="{{route('updatequestion')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('CommonQuestions_trans.question_ar') }}
                                        :</label>
                                    <input id="Name" type="text" name="question_ar" class="form-control Addservice_Namear">
                                    <input  type="hidden" name="question_id" class="form-control Addservice_Namear">

                                    
                                </div>
                                <div class="col">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('CommonQuestions_trans.question_en') }}
                                        :</label>
                                    <input type="text" class="form-control"  id="addGrad_Name" name="question_en"
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
                                    for="exampleFormControlTextarea1">{{ trans('CommonQuestions_trans.answer_ar') }}
                                    :</label>
                                <textarea class="form-control" name="answer_ar" id="exampleFormControlTextarea1"
                                          rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label
                                    for="exampleFormControlTextarea1">{{ trans('CommonQuestions_trans.answer_en') }}
                                    :</label>
                                <textarea class="form-control" name="answer_en" id="exampleFormControlTextarea1"
                                          rows="3"></textarea>
                            </div>
                            <div class="row">
                            <div class="col-12">
                                    <label for="">{{ trans('CommonQuestions_trans.status') }}</label>
                                    <input type="checkbox" name="status" ></input>
                             </div>
                            </div>
                            <div class="form-group">
                               
                            </div>
                            <br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('Service_trans.Close') }}</button>
                        <button  type="edit"
                                class="btn btn-success">{{ trans('Service_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>