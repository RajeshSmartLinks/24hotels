<!-- Delete Modal -->
<div class="modal fade text-left" id="agentMarkUp" tabindex="-1" role="dialog" aria-labelledby="agentMarkUpi20"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h5 class="modal-title" id="agentMarkUpi20">Change MarkUps for <span id="markup_agent_name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="post" id="agentMarkUpForm">
                @csrf
                @method('post')
                <div class="modal-body">
                    <input type="hidden" name="markup_id" id="markup_id" value=""/>
                    <input type="hidden" name="hotel_markup_id" id="hotel_markup_id" value=""/>
                    <h5> Flight Markup </h5>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <label for="first-name-column">{{__('admin.fee_type')}}</label>
                            <select name="fee_type" class="form-control @error('fee_type') is-invalid @enderror">
                                <option value=""> select Fee type</option>
                                <option value="addition" >{{ucfirst('addition')}}</option>
                                <option value="subtraction" >{{ucfirst('subtraction')}}</option>
                            </select>
                        </div>
                     
                        <div class="col-6">
                            <label for="first-name-column">{{__('admin.fee_value')}}</label>
                            <select name="fee_value" class="form-control @error('fee_value') is-invalid @enderror">
                                <option value=""> select Fee Value</option>
                                <option value="fixed" >{{ucfirst('fixed')}}</option>
                                <option value="percentage" >{{ucfirst('percentage')}}</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="first-name-column">{{__('admin.fee_amount')}}</label>
                            <input type="number" id="fee_amount" class="form-control @error('fee_amount') is-invalid @enderror" placeholder="{{__('admin.fee_amount')}}" name="fee_amount"  autocomplete="off" value="">
                        </div>
                    </div>
                    <h5 style="padding-top: 20px"> Hotel Markup </h5>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <label for="first-name-column">{{__('admin.fee_type')}}</label>
                            <select name="hotel_fee_type" class="form-control @error('hotel_fee_type') is-invalid @enderror">
                                <option value=""> select Fee type</option>
                                <option value="addition" >{{ucfirst('addition')}}</option>
                                <option value="subtraction" >{{ucfirst('subtraction')}}</option>
                            </select>
                        </div>
                     
                        <div class="col-6">
                            <label for="first-name-column">{{__('admin.fee_value')}}</label>
                            <select name="hotel_fee_value" class="form-control @error('hotel_fee_value') is-invalid @enderror">
                                <option value=""> select Fee Value</option>
                                <option value="fixed" >{{ucfirst('fixed')}}</option>
                                <option value="percentage" >{{ucfirst('percentage')}}</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="first-name-column">{{__('admin.fee_amount')}}</label>
                            <input type="number" id="hotel_fee_amount" class="form-control @error('hotel_fee_amount') is-invalid @enderror" placeholder="Hotel Fee Amount" name="hotel_fee_amount"  autocomplete="off" value="">
                        </div>
                    </div>



                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
