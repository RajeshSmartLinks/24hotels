<!-- Delete Modal -->
<div class="modal fade text-left" id="addFunds" tabindex="-1" role="dialog" aria-labelledby="addFundsi20"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title" id="addFundsi20">Add Funds in <span id="agent_name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="post" id="addFundsForm">
                @csrf
                @method('post')
                <div class="modal-body">
                    <input type="hidden" name="agent_id" id="agent_id" value=""/>
                    <div class="row">
                        <div class="col-12">
                            <label for="first-name-column"> Amount</label>
                            <div class="form-label-group">
                                <input type="number" id="wallet_balance" class="form-control" placeholder="Wallet Balance" name="wallet_balance" value="" autocomplete="off" required>
                                @error('wallet_balance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                        </div>
                     
                            <div class="col-6">

                                <label for="first-name-column"> Type</label>
                                <div class="form-label-group">
                                    <select name="wallet_amount_type" class="form-control " id="basicSelect" required>
                                        <option value="">--select Type --</option>
                                        <option value="cash" @if (old('type') == "cash") {{ 'selected' }} @endif>Cash</option>
                                        <option value="cheque" @if (old('type') == "cheque") {{ 'selected' }} @endif>Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="first-name-column"> Reference Id</label>
                                <div class="form-label-group">
                                    <input type="text" id="wallet_reference_id" class="form-control " placeholder="Wallet Balance" name="reference_id" value="" autocomplete="off" required>
                                </div>
                            </div>
                       
                        <div class="col-12">
                            <label for="first-name-column">Description (optional)</label>
                            <div class="form-label-group">
                                <textarea type="number" id="description" class="form-control " placeholder="description" name="description"autocomplete="off"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                        </div>
                        
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
