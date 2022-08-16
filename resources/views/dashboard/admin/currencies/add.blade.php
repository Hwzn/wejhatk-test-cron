<div class="modal fade" id="addCurrency_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('Currencies_trans.add currency') }}
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
                        <form action="{{route('addcurrency')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('Currencies_trans.currency_ar') }}
                                        :</label>
                                    <input id="Name" type="text" name="name_ar" class="form-control Addservice_Namear">
                                </div>
                                <div class="col">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('Currencies_trans.currency_en') }}
                                        :</label>
                                    <input type="text" class="form-control"  id="addGrad_Name" name="name_en"
                                      class="form-control Addservice_Nameen">
                                </div>
                                
                            </div>
                           
                            <div class="row">
                                <div class="col">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('Currencies_trans.currencysymbol_ar') }}
                                        :</label>
                                    <input id="Name" type="text" name="shortname_ar" class="form-control Addservice_Namear">
                                </div>
                                <div class="col">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('Currencies_trans.currencysymbol_en') }}
                                        :</label>
                                    <input type="text" class="form-control"  id="addGrad_Name" name="shortname_en"
                                      class="form-control Addservice_Nameen">
                                </div>
                                
                            </div>
                            <br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('Currencies_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('Currencies_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>