<div class="modal fade" id="addpackage_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('packages_trans.add_package') }}
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
                        <form action="{{route('add_package')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('packages_trans.destnation_ar') }}
                                        :</label>
                                    <input id="Name" type="text" name="destnation_ar" class="form-control Addservice_Namear">
                                </div>
                                <div class="col-4">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('packages_trans.destnation_en') }}
                                        :</label>
                                    <input type="text" class="form-control"  id="addGrad_Name" name="destnation_en"
                                      class="form-control Addservice_Nameen">
                                      @error('Name_en')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                </div>
                                <div class="col-4">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('packages_trans.currency') }}
                                        :</label>

                                    <div class="box">
                                                <select  class="fancyselect" name="currency_id">
                                                @foreach($currencies as $currency)
                                                   <option value="{{$currency->id}}">{{$currency->name }}</option>
                                                  @endforeach
                                                </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                              
                                <div class="col-3">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('packages_trans.price') }}
                                        :</label>
                                    <input type="text" class="form-control"   name="price"
                                      class="form-control">
                                </div>
                                <div class="col-3">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('packages_trans.person_num_ar') }}
                                        :</label>
                                    <input type="text" class="form-control"   name="personnum_ar"
                                      class="form-control">
                                </div>
                                <div class="col-3">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('packages_trans.person_num_en') }}
                                        :</label>
                                    <input type="text" class="form-control"   name="personnum_en"
                                      class="form-control">
                                </div>
                                <div class="col-3">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('packages_trans.days') }}
                                        :</label>
                                    <input type="text" class="form-control"   name="days"
                                      class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            for="exampleFormControlTextarea1">{{ trans('packages_trans.package_desc_ar') }}
                                            :</label>
                                        <textarea class="form-control" name="packagedesc_ar" id="exampleFormControlTextarea1"
                                                rows="3"></textarea>
                                    </div>
                               </div>
                                <div class="col-6">
                                <div class="form-group">
                                    <label
                                        for="exampleFormControlTextarea1">{{ trans('packages_trans.package_desc_en') }}
                                        :</label>
                                    <textarea class="form-control" name="packagedesc_en" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                </div>
                          </div>
                    </div>

                    <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            for="exampleFormControlTextarea1">{{ trans('packages_trans.package_contain_ar') }}
                                            :</label>
                                        <textarea class="form-control" name="packagecontain_ar" id="exampleFormControlTextarea1"
                                                rows="3"></textarea>
                                    </div>
                               </div>
                                <div class="col-6">
                                <div class="form-group">
                                    <label
                                        for="exampleFormControlTextarea1">{{ trans('packages_trans.package_contain_en') }}
                                        :</label>
                                    <textarea class="form-control" name="packagecontain_en" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                </div>
                          </div>
                    </div>

                    <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            for="exampleFormControlTextarea1">{{ trans('packages_trans.conditions_ar') }}
                                            :</label>
                                        <textarea class="form-control" name="conditions_ar" id="exampleFormControlTextarea1"
                                                rows="3"></textarea>
                                    </div>
                               </div>
                                <div class="col-6">
                                <div class="form-group">
                                    <label
                                        for="exampleFormControlTextarea1">{{ trans('packages_trans.conditions_en') }}
                                        :</label>
                                    <textarea class="form-control" name="conditions_en" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                </div>
                          </div>
                    </div>

                    <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            for="exampleFormControlTextarea1">{{ trans('packages_trans.cancel_conditions_ar') }}
                                            :</label>
                                        <textarea class="form-control" name="cancelconditions_ar" id="exampleFormControlTextarea1"
                                                rows="3"></textarea>
                                    </div>
                               </div>
                                <div class="col-6">
                                <div class="form-group">
                                    <label
                                        for="exampleFormControlTextarea1">{{ trans('packages_trans.cancel_conditions_en') }}
                                        :</label>
                                    <textarea class="form-control" name="cancelconditions_en" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                </div>
                          </div>
                    </div>
                    
                    <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label
                                            for="exampleFormControlTextarea1">{{ trans('packages_trans.Package_notinclude_ar') }}
                                            :</label>
                                        <textarea class="form-control" name="notinclude_ar" id="exampleFormControlTextarea1"
                                                rows="3"></textarea>
                                    </div>
                               </div>
                                <div class="col-6">
                                <div class="form-group">
                                    <label
                                        for="exampleFormControlTextarea1">{{ trans('packages_trans.Package_notinclude_en') }}
                                        :</label>
                                    <textarea class="form-control" name="notinclude_en" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                </div>
                          </div>
                    </div>
                    
                    
                    <div class="row">
                                <div class="col-6">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('packages_trans.ploicy_conditions') }}
                                        :</label>

                                    <div class="box">
                                                <select  class="fancyselect" name="policy_id">
                                                @foreach($return_policiy as $return_police)
                                                   <option value="{{$return_police->id}}">{{$return_police->name }}</option>
                                                  @endforeach
                                                </select>
                                    </div>

                                </div>
                            </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('packages_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('packages_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>