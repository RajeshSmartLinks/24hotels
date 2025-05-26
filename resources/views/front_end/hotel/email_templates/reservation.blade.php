<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hotel Reservation</title>
<style type="text/css">
@media only screen and (max-width: 600px) {
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
/* table {page-break-before:auto;} */
.page-break {
  page-break-after: always;
}
</style>
</head>
<body style="margin:0; border: none; background:#f5f7f8">
<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
  <tr>
    <td align="center" valign="top"><table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="500" bgcolor="#ffffff" style="border-width:1px; border-style: solid; border-collapse: separate; border-color:#ededed; margin-top:20px; margin-left: 20px; font-family:Arial, Helvetica, sans-serif">

      
        <tr>
          <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td width="100%" height="30">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="center"><a href="{{url('/')}}"><img alt="" src="{{asset("frontEnd/images/logo.png")}}" style="padding-bottom: 0; display: inline !important;"></a></td>
                </tr>
                <tr>
                  @if(isset($result['showDownload']) && ($result['showDownload'] == 1))
                    <td width="100%" height="30"><div valign="top" align="right" style="padding-right: 28px;"> 
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"></path>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"></path>
                      </svg><a href="javascript:window.print()" style="align: revert;">Print</a></div>
                    </td>
                  @else
                    <td width="100%" height="30">&nbsp;</td>
                  @endif
                </tr>
                <tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:0px 20px;"><table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="border:4px solid #eee; border-radius:4px; padding:25px 0px;"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                      <tbody>
                        <tr>
                          <td width="50" style="font-size:14px; padding:0px 25px;"><img alt="" src="{{asset("frontEnd/images/hotel-booking-successful.png")}}"></td>
                          <td style="font-size:16px; font-weight:600; color:#777; line-height:26px; padding-right:20px;"><span style="font-size:13px;">Hi {{$result['user']}},</span><br>Thanks! Your reservation is 
                            <span style="color:#28a745;">{{$result['hotel_booking_Details']->reservation_status}}</span>.</td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:20px;"><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td width="50%" style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Customer Name -</span> {{$result['hotel_booking_Details']->mobile}}</td>
                  <td width="50%" style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Customer Email -</span> {{$result['hotel_booking_Details']->email}}</td>
                </tr>
                <tr>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Booking Number:</span> <a style="outline:none; color:#0071cc; text-decoration:none;" href="#">{{$result['hotel_booking_Details']->booking_ref_id}}</a></td>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Booking Status:</span> {{$result['hotel_booking_Details']->reservation_status}}</td>
                </tr>
                <tr>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Booking Date:</span> {{date('d M, Y', strtotime($result['hotel_booking_Details']->created_at))}}</td>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Payment:</span> by {{$result['hotel_booking_Details']->payment_gateway}}</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td class="tablepadding" style="border-top:1px solid #e9e9e9;border-bottom:1px solid #e9e9e9;padding:25px 20px;"><table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td colspan="4" valign="top" style="font-size:14px; line-height:20px; padding-bottom:25px;"><span style="color:#909090; font-size:13px;">Hotel Details:</span><br />
                    <span style="color:#000000;display:inline-block">{{$result['hotel_details']->hotel_name}}</span><br>
                    <span style="font-size:13px; color:#909090;">{{$result['hotel_details']->address}}</span></td>
                </tr>
                <tr>
                  <td valign="top" width="22%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">Check In:</span><br />
                    {{$result['hotel_booking_Details']->check_in}}</td>
                  <td valign="top" width="22%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">Check Out:</span><br />
                    {{$result['hotel_booking_Details']->check_out}}</td>
                  <td valign="top" width="23%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">No. of guest:</span><br />
                    {{$result['hotel_booking_Details']->no_of_guests}}</td>
                  <td valign="top" width="33%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">No. of rooms and nights:</span><br />
                    {{$result['hotel_booking_Details']->no_of_rooms}} room for {{$result['hotel_booking_Details']->no_of_nights}} nights</td>
                </tr>
                <tr>
                  <td colspan="4" valign="top" style="font-size:13px; line-height:25px; color:#808080; padding-top:20px;"><strong>Note:</strong> The standard check-in time is <strong>{{$result['hotel_details']->check_in}}</strong> and the standard check-out time is <strong>{{$result['hotel_details']->check_out}}</strong>.</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:25px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">Guests List</h3></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px 20px;"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <thead>
                <tr>
                  <td style="font-size:13px;border-right:1px solid #dddddd;background-color:#f8f8fa;font-weight:bold;padding:10px 7px;color:#505050">Title</td>
                  <td style="font-size:13px; border-right:1px solid #dddddd;background-color:#f8f8fa;font-weight:bold;padding:10px 7px;color:#505050">First name</td>
                  <td style="font-size:13px; background-color:#f8f8fa;font-weight:bold;padding:10px 7px;color:#505050">Last name</td>
                  
                  
                </tr>
              </thead>
              <tbody>
                  @foreach($result['hotel_booking_travelers_info'] as $guestsInfo)
                <tr>
                  {{-- <td valign="top" style="font-size:14px; line-height:20px; padding:12px 7px; border-top: 1px solid #eaebed; border-bottom: 1px solid #eaebed; color:#404040">Room Charges
                  </td>
                  <td style="font-size:14px; line-height:20px; padding: 12px 7px 12px 0px; border-top: 1px solid #eaebed; border-bottom: 1px solid #eaebed; color: #404040;" valign="top" align="right"><strong>{{$result['hotel_booking_Details']->currency_code}}{{$result['hotel_booking_Details']->basefare}}</strong></td> --}}

                  <td width="33%" valign="top" style="padding:7px;line-height:22px;">{{$guestsInfo->title}} </td>
                  <td width="33%" valign="top" style="padding:7px;line-height:22px;">{{$guestsInfo->first_name}}</td>
      
                  <td width="33%" valign="top" style="padding:7px;line-height:22px;">{{$guestsInfo->last_name}} </td>




                </tr>
                @endforeach
                
              
              </tbody>
            </table>
            
          </td>
        </tr>
        <tr>
          <td style="padding:25px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;"> Price Summary</h3></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px 20px;"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <thead>
                <tr>
                  <td style="font-size:13px;border-right:1px solid #dddddd;background-color:#f8f8fa;font-weight:bold;padding:10px 7px;color:#505050">Description</td>
                  <td align="right" style="font-size:13px; background-color:#f8f8fa;font-weight:bold;padding:10px 7px;color:#505050">Amount</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td valign="top" style="font-size:14px; line-height:20px; padding:12px 7px; border-top: 1px solid #eaebed; border-bottom: 1px solid #eaebed; color:#404040">Room Charges<br>
                    <span style="font-size:12px; color:#808080"> {{$result['hotel_booking_Details']->no_of_nights}} Night X {{$result['hotel_booking_Details']->no_of_rooms}} Rooms</span></td>
                  <td style="font-size:14px; line-height:20px; padding: 12px 7px 12px 0px; border-top: 1px solid #eaebed; border-bottom: 1px solid #eaebed; color: #404040;" valign="top" align="right"><strong>{{$result['hotel_booking_Details']->currency_code}}   {{$result['hotel_booking_Details']->basefare}}</strong></td>
                </tr>
                <tr>
                  <td style="font-size:14px; line-height:20px; padding:12px 7px; border-bottom: 1px solid #eaebed; color:#404040">Other Charges</td>
                  <td style="font-size:14px; line-height:20px; padding: 12px 7px 12px 0px; border-bottom: 1px solid #eaebed; color: #404040;" valign="top" align="right"><strong>{{$result['hotel_booking_Details']->currency_code}} {{$result['hotel_booking_Details']->service_charges}}</strong></td>
                </tr>
                {{-- <tr>
                  <td style="font-size:14px; line-height:20px; padding:12px 7px; color:#404040">Promotional Code<br>
                    <span style="font-size:12px; color:#808080">SUMMERFUN - 20.00% One Time Discount</span></td>
                  <td style="font-size:14px; line-height:20px; padding: 12px 7px 12px 0px; color: #404040; font-weight: bold;" valign="top" align="right">-$100.00</td>
                </tr> --}}
              </tbody>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="background-color:#efefef; border-radius:4px; padding:15px 20px;"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                      <tbody>
                        <tr>
                          <td align="right" style="font-size:14px; line-height:25px; color:#404040; font-weight: bold;">Sub Total Payment:</td>
                          <td style="font-size:16px; line-height:25px; color: #404040;" valign="top" align="right">{{$result['hotel_booking_Details']->currency_code}} {{$result['hotel_booking_Details']->basefare + $result['hotel_booking_Details']->service_charges }}</td>
                          
                        </tr>
                        <tr>
                          <td align="right" style="font-size:14px; line-height:25px; color:#404040; font-weight: bold;">Tax:</td>
                          <td style="font-size:16px; line-height:25px; color: #404040;" valign="top" align="right">{{$result['hotel_booking_Details']->currency_code}} {{$result['hotel_booking_Details']->tax}}</td>
                        </tr>
                        <tr>
                          <td align="right" style="font-size:14px; line-height:25px; color:#404040; font-weight: bold;">Coupon:</td>
                          <td style="font-size:16px; line-height:25px; color: #404040;" valign="top" align="right">-{{$result['hotel_booking_Details']->currency_code}} {{$result['hotel_booking_Details']->coupon_amount}}</td>
                        </tr>
                        <tr>
                          <td align="right" style="font-size:14px; line-height:25px; color:#404040; font-weight: bold;">Total Payment:</td>
                          <td style="font-size:16px; line-height:25px; color: #404040;" valign="top" align="right"><strong>{{$result['hotel_booking_Details']->currency_code}} {{$result['hotel_booking_Details']->total_amount}}</strong></td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
                @if(!empty($result['hotel_booking_Details']->supplement_charges))
                <tr>
                  <td valign="top" align="center" style="font-size:13px; line-height:25px; color:#808080; padding-top:20px;"><strong>Please Note:</strong> additional supplements ({{$result['hotel_booking_Details']->supplement_charges}}) are not added to this total.</td>
                </tr>
                @endif
                <tr>
                  <td valign="top" align="center" style="font-size:13px; line-height:25px; color:#808080; padding-top:20px;">
                    <strong>
                    Thank you for choosing to make a reservation with us. 
                    If you need to make any changes or cancellations to your reservation, we kindly request that you contact our customer care team Call/ WhatsApp at <strong><a href="tel:+965 6704 1515" >+965 6704 1515 </a></strong> (or) <strong><a href="mailto: booking@24flights.com">booking@24Flights.com</a></strong>
                    This is because hotel cancellations and changes are subject to their policies and terms, and our team will be best equipped to assist you in making any necessary modifications.
                  </td>
                </tr>
              </tbody>
            </table></td>
        </tr>

        
        <tr>
          {{-- <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#555555; font-family:Arial, Helvetica, sans-serif;">
              <tbody>
                <tr>
                  <td class="tablepadding" align="center" style="font-size:14px; line-height:32px; padding:34px 20px; border-top:1px solid #e9e9e9;"> Any Questions? Get in touch with our 24x7 Customer Care team.<br />
                    <a href="#" style="background-color:#0071cc; color:#ffffff; padding:8px 25px; border-radius:4px; font-size:14px; text-decoration:none; display:inline-block; text-transform:uppercase; margin-top:10px;">Contact Customer Care</a></td>
                </tr>
                <tr> </tr>
              </tbody>
            </table></td> --}}
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
        <tbody>
          <tr>
            <td class="tablepadding" style="padding:20px 0; border-collapse:collapse">
                {{-- <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
                <tbody>
                  <tr>
                    <td align="center" class="tablepadding" style="line-height:20px; padding:20px;"> Quickai Template, 2705 N. Enterprise St
                      Orange, CA 92865.</td>
                  </tr>
                </tbody>
              </table> --}}
              {{-- <table align="center">
                <tr>
                  <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="facebook.png" width="32" height="32" alt=""></a></td>
                  <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="twitter.png" width="32" height="32" alt=""></a></td>
                  <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="google_plus.png" width="32" height="32" alt=""></a></td>
                  <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="pinterest.png" width="32" height="32" alt=""></a></td>
                </tr>
              </table> --}}
              <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
                <tbody>
                  <tr>
                    <td class="tablepadding" align="center" style="line-height:20px; padding-top:10px; padding-bottom:20px;">Copyright &copy; {{date('Y')}} 24Flights. All Rights Reserved.</td>
                  </tr>
                  @if(isset($result['showDownload']) && ($result['showDownload'] == 1))
                  <tr>
                    <td class="tablepadding" align="center" style="line-height:20px; padding-top:10px; padding-bottom:20px;"><a href="{{url('/')}}">&laquo; Back to Home</a></td>
                  </tr>
                  @endif
                </tbody>
              </table></td>
          </tr>
        </tbody>
      </table></td>
  </tr>
</table>
</body>
</html>