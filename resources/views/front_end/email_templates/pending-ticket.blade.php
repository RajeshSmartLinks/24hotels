<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight Pending Email Template </title>
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
</style>
</head>
<body style="margin:0; border: none; background:#f5f7f8">
<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
  <tr>
    <td align="center" valign="top"><table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="600" bgcolor="#ffffff" style="border-width:1px; border-style: solid; border-collapse: separate; border-color:#ededed; margin-top:20px; font-family:Arial, Helvetica, sans-serif">
        <tr>
          <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td width="100%" height="30">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="center"><a href="#"><img alt="" src="{{asset("frontEnd/images/logo.png")}}" style="padding-bottom: 0; display: inline !important;"></a></td>
                </tr>
                <tr>
                  <td width="100%" height="30">&nbsp;</td>
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
                          <td style="font-size:14px; padding:0px 25px;" width="50"><img alt="" style="height: 50px;" src="{{asset("frontEnd/images/pending.jpg")}}"></td>
                          <td style="font-size:16px; font-weight:600; color:#777; line-height:26px; padding-right:20px;"><span style="font-size:13px;">Hi {{$user}},</span><br>
                            Ticket Pending Confirmation</td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:20px 20px 0; font-size: 14px;"><p>
            Your <strong>booking ID: {{$flightbookingdetails->booking_ref_id}} </strong> is unsuccessful. We have received the payment of <strong> {{$flightbookingdetails->currency_code}} {{$flightbookingdetails->total_amount}} </strong> for the transaction. We are waiting for your ticket to get confirmed.</p>
            <p>

            Usually, <strong>it doesn't take more than 10 minutes.</strong> In case you don’t get any confirmation regarding this within the time frame, please contact
            us immediately.</p><p>
            We would like to apologize for the inconvenience caused to you. Also, don’t worry! In case your ticket is not confirmed, we will refund your
            money back. Feel free to call us / mail us on below mentioned details if you need any help in com</p>
            </td>
        </tr>
    
        <tr>
          <td style="padding:10px 20px;"><h3 style="margin:0; font-weight:normal; color:#444444;">Why did I get this message</h3></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:0px 20px 15px;"><table style="border-collapse:collapse;width:100%;">
              <tbody>
                <tr>
                  <td align="right" valign="top" width="7%" style="font-size:16px; padding:5px; color:#666666;">&bull;</td>
                  <td style="font-size:13px; padding:5px 7px;"> The servers are busy and taking time to respond.</td>
                </tr>
                <tr>
                  <td align="right" valign="top" width="7%" style="font-size:16px; padding:5px; color:#666666;">&bull;</td>
                  <td style="font-size:13px; padding:5px 7px;"> The fare could have changed and the fare you booked at is no more available.</td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
            <td style="padding:10px 20px 0;"><h3 style="margin:0; font-weight:normal; color:#444444;"> Passenger Details </h3></td>
          </tr>
          <tr>
            <td class="tablepadding" style="padding:15px 20px;"><table style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
                <thead>
                  <tr>
                    <th width="7%" align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">NO.</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Title</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">First Name</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Last Name</th>
                    {{-- <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Gender</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Seat No.</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Status</th> --}}
                  </tr>
                </thead>
                <tbody>
                  @foreach($FlightBookingPassengersInfo as $panssengerData)
                  <tr>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$loop->iteration}}</td>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$panssengerData->title}}</td>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$panssengerData->first_name}}</td>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$panssengerData->last_name}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table></td>
          </tr>
          {{-- <tr>
            <td style="padding:10px 20px 0;"><h3 style="margin:0; font-weight:normal; color:#444444;"> Passenger Details </h3></td>
          </tr>
          <tr>
            <td class="tablepadding" style="padding:15px 20px;"><table style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;">
                <thead>
                  <tr>
                    <th width="7%" align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">NO.</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Name</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Age</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Gender</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Seat No.</th>
                    <th align="left" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;padding:12px 7px;color:#505050">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">1</td>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">Neil Patel</td>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">31</td>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">Male</td>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">C2, 25</td>
                    <td style="font-size:13px; border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">Confirm</td>
                  </tr>
                </tbody>
              </table></td>
          </tr> --}}
        <tr>
          <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#555555; font-family:Arial, Helvetica, sans-serif;">
              <tbody>
                <tr>
                  <td class="tablepadding" align="center" style="font-size:14px; line-height:32px; padding:34px 20px; border-top:1px solid #e9e9e9;"> Any Questions? Get in touch with our 24x7 Customer Care team.<br />
                    <a href="https://api.whatsapp.com/send?phone=96567041515" style="background-color:#0071cc; color:#ffffff; padding:8px 25px; border-radius:4px; font-size:14px; text-decoration:none; display:inline-block; text-transform:uppercase; margin-top:10px;">Contact Customer Care</a></td>
                </tr>
                <tr> </tr>
              </tbody>
            </table></td>
        </tr>
      </table></td>
  </tr>
  {{-- <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
        <tbody>
          <tr>
            <td class="tablepadding" style="padding:20px 0; border-collapse:collapse"><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
                <tbody>
                  <tr>
                    <td align="center" class="tablepadding" style="line-height:20px; padding:20px;"> Quickai Template, 2705 N. Enterprise St
                      Orange, CA 92865.</td>
                  </tr>
                </tbody>
              </table>
              <table align="center">
                <tr>
                  <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="facebook.png" width="32" height="32" alt=""></a></td>
                  <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="twitter.png" width="32" height="32" alt=""></a></td>
                  <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="google_plus.png" width="32" height="32" alt=""></a></td>
                  <td style="padding-right:10px; padding-bottom:9px;"><a href="#" target="_blank" style="text-decoration:none; outline:none;"><img src="pinterest.png" width="32" height="32" alt=""></a></td>
                </tr>
              </table>
              <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
                <tbody>
                  <tr>
                    <td class="tablepadding" align="center" style="line-height:20px; padding-top:10px; padding-bottom:20px;">Copyright &copy; 2022 Quickai. All Rights Reserved. </td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
        </tbody>
      </table></td>
  </tr> --}}
</table>
</body>
</html>