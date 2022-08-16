<!-- add_modal_class -->
<div class="modal fade" id="addService_AttrbuteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('serviceattribute_trans.addservice_attribute') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                         </div>
                <form class=" row mb-30" action="{{route('storeserviceattribute')}}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="repeater">
                            <div id="List_ServiceAttrbites" data-repeater-list="List_ServiceAttrbites">
                                <div data-repeater-item>

                                    <div class="row">
                                      <div class="col">
                                            <label for="Name_en"
                                                class="mr-sm-2">{{ trans('serviceattribute_trans.ChooseService_Name') }}
                                                :</label>

                                            <div class="box">
                                                <select class="fancyselect" name="service_id">
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col">
                                            <label for="Name_en"
                                                class="mr-sm-2">{{ trans('serviceattribute_trans.ChooseAttribute_Name') }}
                                                :</label>

                                            <div class="box">
                                                <select class="fancyselect" name="attributes_id">
                                                   <option value="" selected disabled>{{trans('serviceattribute_trans.select')}}</option>
                                                    @foreach ($attributes as $attribute)
                                                        <option value="{{ $attribute->id }}">{{ $attribute->name }} / ({{$attribute->attributetype_name}})</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                       


                                        <div class="col">
                                            <label for="Name"
                                                class="mr-sm-2">{{ trans('serviceattribute_trans.attribute_order') }}
                                                :</label>
                                            <input class="form-control" type="text" name="attribute_order"  />
                                        </div>


                                      

                                        <div class="col">
                                            <label for="Name_en"
                                                class="mr-sm-2">{{ trans('serviceattribute_trans.delete_row') }}
                                                :</label>
                                            <input class="btn btn-danger btn-block" data-repeater-delete
                                                type="button" value="{{ trans('serviceattribute_trans.delete_row') }}" />
                                        </div>
                                    </div>
                                </div>
                          </div>
                            <div class="row mt-20">
                                <div class="col-12">
                                    <input class="button" data-repeater-create type="button" value="{{ trans('serviceattribute_trans.add_row') }}"/>
                                </div>
                                <br/>

                            </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('serviceattribute_trans.Close') }}</button>
                                <button type="submit"
                                    class="btn btn-success">{{ trans('serviceattribute_trans.submit') }}</button>
                            </div>
                            

                        </div>
                    </div>
                </form>
            </div>


        </div>

    </div>