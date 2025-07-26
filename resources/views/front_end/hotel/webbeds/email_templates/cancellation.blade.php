<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flight Ticket Cancellation </title>
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
                          <td style="font-size:14px; padding:0px 25px;" width="50"><img alt="" style="height: 50px;" src="{{asset("frontEnd/email-template/hotel-email-template/booking-cancel.png")}}"></td>
                          <td style="font-size:16px; font-weight:600; color:#777; line-height:26px; padding-right:20px;"><span style="font-size:13px;">Hi {{$user}},</span><br>
                            Cancellation of the hotel booking has been requested</td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:20px 20px 0; font-size: 14px;"><p>A cancellation or change request has been initiated for hotel booking <strong> {{$HotelBooking->booking_ref_id}}.</strong> </p>
            <p>Please review and process the request accordingly. An executive is expected to follow up with the customer to confirm the changes and communicate any updates to the itinerary or applicable charges..</p>
            </td>            
        </tr>
        <tr>
          <td style="padding:20px 20px 0; font-size: 14px;"><p>Thank you </p>
            <p>MasilaHolidays Reservation Team.</p>
            </td>
        </tr>
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
</table>
</body>
</html>