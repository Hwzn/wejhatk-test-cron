 <!-- delete_modal_Grade -->
 <div class="modal fade" id="delete{{ $serviceattribute->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                id="exampleModalLabel">
                                                {{ trans('serviceattribute_trans.delete_row') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('Delete_attrbuteService') }}" method="post">
                                                @csrf
                                                {{ trans('serviceattribute_trans.Warning_Delete') }}

                                                <input id="Name" type="text" name="Name"
                                                                   class="form-control"
                                                                   value="{{$serviceattribute->services->name }}"
                                                                   disabled>

                                                    <input id="id" type="hidden" name="id" class="form-control"
                                                           value="{{ $serviceattribute->id }}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ trans('serviceattribute_trans.Close') }}</button>
                                                        <button type="submit"
                                                                class="btn btn-danger">{{ trans('serviceattribute_trans.Delete') }}</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>