<html xmlns="http://www.w3.org/1999/xhtml"><head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
  <title>Invoice - MasilaHolidays</title>
  <style type="text/css">
  @media  only screen and (max-width: 520px) {
  table[class="contenttable"] {
    width: 320px !important;
    border-width: 3px!important;
  }
  table[class="tablefull"] {
    width: 100% !important;
  }
  table[class="tablefull"] + table[class="tablefull"] td {
    padding-top: 0px !important;
  }
  table td[class="tablepadding"] {
    padding: 15px !important;
  }
  }
  .addressstyle{
    
    margin-bottom: 1rem;
    font-style: normal;
    line-height: inherit;

  }
  </style>
  </head>
  <body >
  <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tbody><tr>
      <td align="center" valign="top"><table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="520" bgcolor="#ffffff" style="border-width:1px;border-style: solid;border-collapse: separate; border-color:#ededed;margin-top:20px; font-family:Arial, Helvetica, sans-serif;padding: 0px 30px;">
          <tbody>
            <tr>
            <td>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td width="100%" height="30">&nbsp;</td>
                  </tr>
                  <tr>
                    <?php //$img = isset($result['agency']->logo) && !empty($result['agency']->logo) ? 'uploads/agency/'.$result['agency']->logo : 'frontEnd/images/logomh.png';?>
                      
                    <td valign="top" align="left" style="padding: 9px 0px;"><a href="#">
                        <img 
                          {{-- src="{{ asset($img) }}"  --}}
                          src = "{{$result['agencyImgBase64']}}"
                          width="150" 
                          height="100"
                          style="max-width:150px; max-height:100px; display:block;"
                        >
                      </a>
                    </td>
                    <td valign="top" align="right" style="padding: 9px 0px;">
                      <div style=" width: 200px;">
                        <h4 style='font-size: 31px;font-weight: 600; color:#777;line-height:26px;margin: 0px; '>Invoice</h4>
                        <p style=" ">Invoice Number - {{$result['hotelbookingdetails']->invoice_id}}<p>
                      </div>
                    </td>
                  </tr>
                 </tbody>
              </table>
              <hr>
            </td>
              
          </tr>
          
          <tr>
           
          </tr>
          <tr>
            <td style=""><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <tbody>
                <tr>
                  <td style="font-size:14px;" align="left" width="50%"><div class=""> <strong>Invoiced To:</strong>
                    <br>
                    @if($result['hotelbookingdetails']->user_id)
                      {{$result['user']}}
                    @endif
                    <address class="addressstyle">
                      {{$result['hotelbookingdetails']->email}}<br />
                      {{$result['hotelbookingdetails']->mobile}}<br />
                    </address>
                    </div></td>
                    <td style="font-size:14px;" align="right" width="50%"><div sclass=""> <strong>Pay To:</strong>
                      <address class="addressstyle">
                        {{$result['agent']->first_name ." ".$result['agent']->last_name}}<br />
                        {{$result['agency']->name}}<br />
                        {{$result['agency']->address}} <br />
                        {{$result['agency']->phone_number}}
                        </address>
                      </div></td>
                </tr>
                <tr>
                  <td style="font-size:14px;" align="left" width="50%"><div class=""> <strong>Payment method</strong>
                    <p style="margin-top: 0px">{{$result['hotelbookingdetails']->payment_gateway}}</p>
                    </div></td>
                    <td style="font-size:14px;" align="right" width="50%"><div class=""> <strong>Booking date:</strong>
                      <p style="margin-top: 0px">{{date('d-m-Y', strtotime($result['hotelbookingdetails']->created_at))}}</p>
                    </div></td>
                </tr>
                <tr>
                  <td style="font-size:14px;" align="left" width="50%"><div class=""> <strong>Masila Ref Id</strong>
                    <p style="margin-top: 0px">{{$result['hotelbookingdetails']->booking_ref_id}}</p>
                    </div></td>
                    <td style="font-size:14px;padding-top:10px" align="right" width="50%"><div class=""> <strong>Supplier Booking Id :</strong>
                      <p style="margin-top: 0px">{{$result['supplier_booking_ids']}}</p>
                    </div></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
        
          <tr>
            <td style="padding:25px 0px 10px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
              Booking Summary
              </h3></td>
          </tr>
          {{-- <tr>
            <td class="tablepadding" style="padding:20px 0px 25px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
                <thead>
                  <tr>
                    <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Flight Details</td>
                    <td align="center" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Base Fare</td>
                    <td align="center" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Taxes & Fee</td>
                    <td align="center" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Amount</td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($result['segments'] as $k => $segment)
                  <tr>
                    <td width="55%" valign="middle" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$segment['AirLine']->name .' '.$segment['Carrier'].'-'. $segment['FlightNumber']}} -{{$segment['OriginAirportDetails']->city_name .' to '.$segment['DestinationAirportDetails']->city_name }} <br>
                      Travel Date (From) - {{date('d M D Y', strtotime($segment['DepartureDate']))}} , {{$segment['DepartureTime']}} <br>
                      Travel Date (To)- {{date('d M D Y', strtotime($segment['ArrivalDate']))}} , {{$segment['ArrivalTime']}}</td>
                      @if($k == 0)
                      <td width="15%" valign="middle"  rowspan="{{count($result['segments'])}}"  align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$result['hotelbookingdetails']->currency_code .' '.$result['hotelbookingdetails']->basefare}} </td>
                    <td width="15%" valign="middle"  rowspan="{{count($result['segments'])}}"  align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$result['hotelbookingdetails']->currency_code .' '.$result['hotelbookingdetails']->tax}} </td>
                    <td width="15%" valign="middle"  rowspan="{{count($result['segments'])}}"  align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> {{$result['hotelbookingdetails']->currency_code .' '.$result['hotelbookingdetails']->sub_total}} </td>
                    @endif
                  </tr>
                  

                  @endforeach

                  <tr>
                    <td style="font-size:13px;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3" align="right">
                     <strong>Sub Total:</strong> </td>
                    <td style="font-size:13px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" >{{$result['hotelbookingdetails']->currency_code .' '.$result['hotelbookingdetails']->actual_amount}}</td>
                  </tr>
                  <tr>
                    <td style="font-size:13px;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3" align="right">
                     <strong>Coupon Amount:</strong> </td>
                    <td style="font-size:13px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" >- {{$result['hotelbookingdetails']->currency_code . !empty($result['hotelbookingdetails']->coupon_amount)?$result['hotelbookingdetails']->coupon_amount:0 }}</td>
                  </tr>
                  <tr>
                    <td style="font-size:13px;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3" align="right">
                     <strong>Total:</strong> </td>
                    <td style="font-size:13px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" >{{$result['hotelbookingdetails']->currency_code .' '.$result['hotelbookingdetails']->total_amount}}</td>
                  </tr>
                  

                  
                  
                </tbody>
              </table></td>
          </tr> --}}
          <tr>
          <td class="tablepadding" style="border-top:1px solid #e9e9e9;border-bottom:1px solid #e9e9e9;"><table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td colspan="4" valign="top" style="font-size:14px; line-height:20px; padding-bottom:25px;"><span style="color:#909090; font-size:13px;">Hotel Details:</span><br />
                    <span style="color:#000000;display:inline-block">{{$result['hotel_details']->hotel_name}}</span><br>
                    <span style="font-size:13px; color:#909090;">{{$result['hotel_details']->address}}</span></td>
                </tr>
                <tr>
                  <td valign="top" width="22%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">Check In:</span><br />
                    {{date('d M, Y', strtotime($result['hotelbookingdetails']->check_in))}}</td>
                  <td valign="top" width="22%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">Check Out:</span><br />
                    {{date('d M, Y', strtotime($result['hotelbookingdetails']->check_out))}}</td>
                  <td valign="top" width="23%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">No. of guest:</span><br />
                    {{$result['hotelbookingdetails']->no_of_guests}}</td>
                  <td valign="top" width="33%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">No. of rooms and nights:</span><br />
                    {{$result['hotelbookingdetails']->no_of_rooms}} room for {{$result['hotelbookingdetails']->no_of_nights}} nights</td>
                </tr>
                <tr>
                  <td colspan="4" valign="top" style="font-size:13px; line-hcontenttableeight:25px; color:#808080; padding-top:20px;padding-bottom:10px;"><strong>Note:</strong> The standard check-in time is <strong>{{$result['hotel_details']->check_in}}</strong> and the standard check-out time is <strong>{{$result['hotel_details']->check_out}}</strong>.</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
          
          
          <tr>
            <td class="tablepadding" style="padding:20px 0px 25px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
                <thead>
                  <tr>
                    <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Transaction Date</td>
                    <td align="center" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Gateway</td>
                    {{-- <td align="center" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Payment ID</td> --}}
                    <td align="center" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Amount</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="25%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{date('d-m-Y', strtotime($result['hotelbookingdetails']->created_at))}} </td>
                    <td width="25%" valign="top" align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> {{$result['hotelbookingdetails']->payment_gateway}} </td>
                    {{-- <td width="25%" valign="top" align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> {{$result['hotelbookingdetails']->payment_id}} </td> --}}
                    <td width="25%" valign="top" align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> {{$result['hotelbookingdetails']->currency_code .' '.$result['hotelbookingdetails']->total_amount}} </td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
         
          <tr>
            <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#555555; font-family:Arial, Helvetica, sans-serif;">
                <tbody>
                  <tr>
                    <td class="tablepadding" align="center" style="font-size:14px; line-height:32px; padding:34px 20px; border-top:1px solid #e9e9e9;"><strong>NOTE :</strong> This is computer generated receipt and does not require physical signature.<br>
                    </td>
                  </tr>
                  <tr> </tr>
                </tbody>
              </table></td>
          </tr>
        </tbody></table></td>
    </tr>
    
  </tbody></table>
  
  </body></html>