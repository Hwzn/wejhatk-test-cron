 <!-- edit_modal_Grade -->
 <div class="modal fade" id="edit{{ $serviceattribute->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                id="exampleModalLabel">
                                                {{ trans('serviceattribute_trans.Edit') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- add_form  -->
                                            <form action="{{route('updateservice_attribute')}}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                    <div class="col">
                                            <label for="Name_en"
                                                class="mr-sm-2">{{ trans('serviceattribute_trans.ChooseService_Name') }}
                                                :</label>

                                            <div class="box">
                                                <select class="fancyselect" name="service_id">
                                                   <option value="{{$serviceattribute->service_id}}">{{$serviceattribute->services->name}}</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col">
                                            <label for="Name_en"
                                                class="mr-sm-2">{{ trans('serviceattribute_trans.ChooseAttribute_Name') }}
                                                :</label>

                                            <div class="box">
                                                <select class="fancyselect" name="attributes_id" readonly>
                                                   <option value="{{$serviceattribute->attribute_id}}">{{$serviceattribute->attributes->name}}</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col">
                                            <label for="Name"
                                                class="mr-sm-2">{{ trans('serviceattribute_trans.attribute_order') }}
                                                :</label>
                                            <input class="form-control" type="text" name="attribute_order" value="{{$serviceattribute->order}}"  />
                                            <input class="form-control" type="hidden" name="attribute_serviceid" value="{{$serviceattribute->id}}"  />

                                        </div>
                                        </div>


                              
                                      
                                                   
                                         <div class="row">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ trans('serviceattribute_trans.Close') }}</button>
                                                        <button type="submit"
                                                                class="btn btn-success">{{ trans('serviceattribute_trans.Edit') }}</button>
                                                    </div>
                                                    </div> 
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>