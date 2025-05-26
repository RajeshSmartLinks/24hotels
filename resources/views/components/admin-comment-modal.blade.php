<!-- Delete Modal -->
<div class="modal fade text-left" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h5 class="modal-title" id="myModalLabel120">{{aztran('notes')}} - <span id="contract_no"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="post" id="commentForm">
                @csrf
                <div class="modal-body">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>

                    <input type="hidden" name="contract_id" id="contract_id" value=""/>
                    <p></p>
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" id="comments-remark" name="comments" placeholder="{{aztran('notes')}}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnCommentPopup">{{aztran('save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
