<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>24Flights - forgot Password</title>
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
                  <td valign="top" align="center"><a href="#"><img alt="24flights" src="{{$image}}" style="padding-bottom: 0; display: inline !important;"></a></td>
                </tr>
                <tr>
                  <td width="100%" height="30">&nbsp;</td>
                </tr>
                <tr>
              </tbody>
            </table></td>
        </tr>
        <tr>
          <td style="padding:0px 20px;"><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  {{-- <td style="border:4px solid #eee; border-radius:4px; padding:25px 0px;"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                      <tbody>
                        <tr>
                          <td style="font-size:14px; line-height:20px; padding:0px 25px;"><img alt="" src="mobile-successful.png"></td>
                          <td style="font-size:16px; font-weight:600; color:#777; line-height:26px; padding-right:20px;">The Vodafone prepaid recharge payment of <span style="color:#000;">$93.10</span> for Mobile No. <span style="color:#000;">9898989898</span> is now <span style="color:#28a745;">successful!</span></td>
                        </tr>
                      </tbody>
                    </table></td> --}}
                    <td style="font-size:16px; font-weight:600; color:#777; line-height:26px; padding-right:20px;">Hello {{$name}},</td>
                </tr>
                <tr>
                  <td style="padding:10px 0px; line-height:28px; font-size:13px; color:#808080; text-align:left;">You are receving this email because we recevied a password reset requestfor your account</td>
                </tr>
              
              </tbody>
            </table></td>
        </tr>
      
        <tr>
          <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#555555; font-family:Arial, Helvetica, sans-serif;">
              <tbody>
                <tr>
                  <td class="tablepadding" align="center" style="font-size:14px; line-height:32px; padding:5px 20px 5px 20px;">
                    <a href="{{$resetPsswordLink}}" style="background-color:#0071cc; color:#ffffff; padding:8px 25px; border-radius:4px; font-size:14px; text-decoration:none; display:inline-block; text-transform:uppercase; margin-top:10px;">Reset Password</a></td>
                </tr>
                <tr> 
                  <td class="tablepadding" align="center" style="font-size:13px; line-height:32px; padding:5px 20px 0px 20px; color:#808080;">This Password reset link will expire in 60 minutes
                  </td>
                  
                </tr>
                <tr> 
                  <td class="tablepadding" align="center" style="font-size:13px; line-height:32px; padding:5px 20px 0px 20px; color:#808080;">If your did not request a password reset, no further action required,
                  </td>
                </tr>
                <tr> 
                  <td class="tablepadding" align="left" style="font-size:13px; line-height:32px; padding:0px 20px 0px 20px; color:#808080;">
                    Thanks & regards</td>
                </tr>
                <tr> 
                  <td class="tablepadding" align="left" style="font-size:13px; line-height:32px; padding:0px 20px 10px 20px; color:#808080;">
                    24 Flights</td>
                </tr>
                
              </tbody>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
        <tbody>
          <tr>
            <td class="tablepadding" style="padding:20px 0; border-collapse:collapse">
           
              <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
                <tbody>
                  <tr>
                    <td class="tablepadding" align="center" style="line-height:20px; padding-top:10px; padding-bottom:20px;">Copyright &copy; {{date("Y")}} 24Flights. All Rights Reserved. </td>
                  </tr>
                </tbody>
              </table></td>
          </tr>
        </tbody>
      </table></td>
  </tr>
</table>
</body>
</html>