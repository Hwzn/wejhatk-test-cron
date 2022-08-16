<div class="modal fade" id="addads_Modola" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                            id="exampleModalLabel">
                            {{ trans('ads_trans.add_ads') }}
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
                        <form action="{{route('add_ads')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <label for="Name"
                                           class="mr-sm-2">{{ trans('ads_trans.name_ar') }}
                                        :</label>
                                    <input id="Name" type="text" name="name_ar" class="form-control Addservice_Namear">
                                </div>
                                <div class="col-6">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('ads_trans.name_en') }}
                                        :</label>
                                    <input type="text" class="form-control"  id="addGrad_Name" name="name_en"
                                      class="form-control Addservice_Nameen">
                                      @error('Name_en')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                </div>
                              
                            </div>
                            <div class="row">
                              <div class="col-6">
                                    <label for="Name_en"
                                           class="mr-sm-2">{{ trans('ads_trans.price') }}
                                        :</label>
                                    <input type="text" class="form-control"   name="price"
                                      class="form-control">
                                </div>
                                <div class="col-6">
                                <label for="Name"
                                           class="mr-sm-2">{{ trans('ads_trans.currency') }}
                                        :</label>

                                    <div>
                                                <select  class="fancyselect" name="currency_id">
                                                @foreach($currency as $currency)
                                                   <option value="{{$currency->id}}">{{$currency->name }}</option>
                                                  @endforeach
                                                </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label
                                            for="exampleFormControlTextarea1">{{ trans('ads_trans.desc_ar') }}
                                            :</label>
                                        <textarea class="form-control" name="desc_ar" id="exampleFormControlTextarea1"
                                                rows="3"></textarea>
                                    </div>
                               </div>
                             </div>
                             <div class="row">
                                <div class="col-12">
                                <div class="form-group">
                                    <label
                                        for="exampleFormControlTextarea1">{{ trans('ads_trans.desc_en') }}
                                        :</label>
                                    <textarea class="form-control" name="desc_en" id="exampleFormControlTextarea1"
                                            rows="3"></textarea>
                                </div>
                             </div>
                        </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{  trans('ads_trans.Close') }}</button>
                        <button  type="add"
                                class="btn btn-success">{{ trans('ads_trans.submit') }}</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>