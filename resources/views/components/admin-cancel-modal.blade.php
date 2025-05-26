<!-- Delete Modal -->
<div class="modal fade text-left" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h5 class="modal-title" id="myModalLabel120">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route($routename, 'test')}}" method="post" id="cancelForm">
                @csrf
                <div class="modal-body">
                    {{aztran('contract_cancel_confirm')}}
                    <input type="hidden" name="cancel_id" id="cancel_id" value=""/>
                    <hr>
                    <p></p>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <input type="radio" id="cancel"
                                       name="cancel"
                                       value="cancel" autocomplete="off"> <strong>{{aztran('cancel')}}</strong>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <input type="radio" id="transfer"
                                       name="cancel"
                                       value="transfer" autocomplete="off"> <strong>{{aztran('transfer')}}</strong>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <input type="radio" id="close"
                                       name="cancel"
                                       value="close" autocomplete="off"> <strong>{{aztran('close')}}</strong>
                            </div>
                        </div>
                    </div>

                    <p></p>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" id="comments" name="comments" placeholder="{{aztran('notes')}}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">{{aztran('accept')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
