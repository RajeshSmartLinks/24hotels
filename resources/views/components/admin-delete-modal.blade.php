<!-- Delete Modal -->
<div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h5 class="modal-title" id="myModalLabel120">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route($routename, 'test')}}" method="post" id="deleteForm">
                @csrf
                @method('delete')
                <div class="modal-body">
                    Are you sure to delete?
                    <input type="hidden" name="delete_id" id="delete_id" value=""/>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Accept</button>
                </div>
            </form>
        </div>
    </div>
</div>
