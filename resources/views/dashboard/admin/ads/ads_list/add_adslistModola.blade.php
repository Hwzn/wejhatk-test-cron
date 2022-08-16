<!-- add_modal_class -->
<div class="modal fade" id="add_adslistModola" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('ads_trans.add_adsList') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                         </div>
                <form class=" row mb-30" action="{{route('storeads_list')}}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="repeater">
                            <div id="List_adsAttrbiteselemnt" data-repeater-list="List_adsAttrbiteselemnt">
                                <div data-repeater-item>

                                    <div class="row">
                                      <div class="col">
                                            <label for="Name_en"
                                                class="mr-sm-2">{{ trans('ads_trans.appearance_order') }}
                                                :</label>

                                            <div class="box">
                                                <select class="fancyselect" name="appearance_order">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col">
                                        <label for="Name_en"
                                                class="mr-sm-2">{{ trans('ads_trans.duration_ar') }}
                                                :</label>
                                        <div class="box">
                                                <select class="fancyselect" name="duration_ar">
                                                        <option value="أسبوع">أسبوع</option>
                                                        <option value="شهر">شهر</option>
                                                        <option value="ربع سنه">ربع سنه</option>
                                                        <option value="سنة">سنة</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col">
                                        <label for="Name_en"
                                                class="mr-sm-2">{{ trans('ads_trans.duration_en') }}
                                                :</label>
                                        <div class="box">
                                            <select class="fancyselect" name="duration_en">
                                                        <option value="Week">Week</option>
                                                        <option value="Month">Month</option>
                                                        <option value="quarter_year">quarter_year</option>
                                                        <option value="Year">Year</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col">
                                            <label for="Name"
                                                class="mr-sm-2">{{ trans('ads_trans.price') }}
                                                :</label>
                                            <input class="form-control" type="text" value="<?php echo 0 ?>" name="price"  />
                                        </div>
                                        <div class="col">
                                        <label for="Name_en"
                                                class="mr-sm-2">{{ trans('ads_trans.currency') }}
                                                :</label>
                                        <div class="box">
                                            <select class="fancyselect" name="currency_id">
                                                     @foreach($currency as $currency)
                                                        <option value="{{$currency->id}}">{{$currency->short_name}}</option>
                                                     @endforeach;
                                                </select>
                                            </div>

                                        </div>

                                       
                                   
                                    </div>
                                </div>
                          </div>
                            <div class="row mt-20">
                                <div class="col-12">
                                    <input class="button" data-repeater-create type="button" value="{{ trans('DropDownLists_trans.add_record') }}"/>
                                </div>
                                <br/>

                            </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('DropDownLists_trans.Close') }}</button>
                                <button type="submit"
                                    class="btn btn-success">{{ trans('DropDownLists_trans.submit') }}</button>
                            </div>
                            

                        </div>
                    </div>
                </form>
            </div>


        </div>

    </div>