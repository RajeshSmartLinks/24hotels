<!-- Delete Modal -->
<div class="modal fade text-left" id="whatsAppModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel121"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h5 class="modal-title" id="myModalLabel121">{{aztran('whats_app')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.whatsapp.sendMessage')}}" method="post" id="whatsAppMessagaeSentForm">
                @csrf
                <div class="modal-body">
                    
                    <input type="hidden" name="contract_id" id="contract_id" value=""/>
                    {{aztran('select_template')}}
                    <hr>
                    <div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="radio" id="whatsappTemplate" name="whatsappTemplate"  value="legal_process" autocomplete="off"> <strong>{{aztran('legal_process')}}</strong>
                            </div>
                        </div>
                        {{-- <div class="col-12">
                            <div class="form-group">
                                <input type="radio" id="whatsappTemplate" name="whatsappTemplate"  value="payment_reminder" autocomplete="off"> <strong>{{aztran('payment_reminder')}}</strong>
                            </div>
                        </div> --}}
                        <div class="col-12">
                            <div class="form-group">
                                <input type="radio" id="whatsappTemplate" name="whatsappTemplate"  value="car_transfer_reminder" autocomplete="off"> <strong>{{aztran('car_transfer_reminder')}}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="radio" id="whatsappTemplate" name="whatsappTemplate"  value="traffic_fine_message" autocomplete="off"> <strong>{{aztran('traffic_fines')}}</strong>
                            </div>
                        </div>
                        <div style="color: red;display:none" id ="whatsAppTemplateError">{{aztran('please_select_message_template')}}</div>
                       
                    </div>
                    <hr>
                    {{aztran('select_language')}}
                    <hr>
                    <div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="radio" id="whatsappTemplateLanguage" name="whatsappTemplateLanguage"  value="en" autocomplete="off"> <strong>{{aztran('english')}}</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="radio" id="whatsappTemplateLanguage" name="whatsappTemplateLanguage"  value="ar" autocomplete="off"> <strong>{{aztran('arabic')}}</strong>
                            </div>
                        </div>
                      
                        <div style="color: red;display:none" id ="whatsappTemplateLanguageError">{{aztran('please_select_language')}}</div>
                       
                    </div>


                </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" id="acceptButton">{{aztran('send')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
