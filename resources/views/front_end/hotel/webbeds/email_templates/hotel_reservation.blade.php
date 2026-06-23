<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hotel Reservation</title>
<style type="text/css">
.page-break {
  page-break-after: always;
}
</style>
</head>
<body style="margin:0; border: none; background:#f5f7f8">
<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
  <tr>
    <td align="center" valign="top">
      <table class="contenttable" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff" style="border-width:1px; border-style: solid; border-collapse: collapse; border-color:#ededed; margin-top:20px; margin-left: 20px; font-family:Arial, Helvetica, sans-serif">

      
        <tr>
          <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td width="100%" height="30">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top" align="center">
                    <a href="#">
                      <img alt="" src="{{ $result['agencyImg'] ?? '' }}" style="padding-bottom: 0; display: inline !important; width: 200px; height: 100px;">
                    </a>
                  </td>
                </tr>
                <tr>
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
                          <td width="50" style="font-size:14px; padding:0px 25px;">
                            <img alt="" src="{{$result['successImg']}}">
                            {{-- <img alt="" src="{{$result['successImgBase64']}}"> --}}
                          </td>
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
                  <td width="50%" style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Customer Name -</span> {{$result['user']}}</td>
                  <td width="50%" style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Customer Email -</span> {{$result['hotel_booking_Details']->email}}</td>
                </tr>
                <tr>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Booking Number:</span> {{$result['hotel_booking_Details']->booking_ref_id}}</td>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Booking Status:</span> {{$result['hotel_booking_Details']->reservation_status}}</td>
                </tr>
                <tr>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Booking Date:</span> {{date('d M, Y', strtotime($result['hotel_booking_Details']->created_at))}}</td>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Payment:</span> by {{$result['hotel_booking_Details']->payment_gateway}}</td>
                </tr>
                <tr>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Client Booking Number:</span> {{$result['hotel_booking_Details']->booking_reference_number}}</td>
                  <td style="font-size:14px; line-height:28px;"><span style="color:#7a7a7a;">Agency Name:</span> by {{$result['agencyName']}}</td>
                  
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
                    {{date('d M, Y', strtotime($result['hotel_booking_Details']->check_in))}}</td>
                  <td valign="top" width="22%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">Check Out:</span><br />
                    {{date('d M, Y', strtotime($result['hotel_booking_Details']->check_out))}}</td>
                  <td valign="top" width="23%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">No. of guest:</span><br />
                    {{$result['hotel_booking_Details']->no_of_guests}}</td>
                  <td valign="top" width="33%" style="font-size:14px; line-height:20px;"><span style="color:#909090; font-size:13px;">No. of rooms and nights:</span><br />
                    {{$result['hotel_booking_Details']->no_of_rooms}} room for {{$result['hotel_booking_Details']->no_of_nights}} nights</td>
                </tr>
                <tr>
                  <td colspan="4" valign="top" style="font-size:13px; line-hcontenttableeight:25px; color:#808080; padding-top:20px;"><strong>Note:</strong> The standard check-in time is <strong>{{$result['hotel_details']->check_in}}</strong> and the standard check-out time is <strong>{{$result['hotel_details']->check_out}}</strong>.</td>
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

                  <td width="33%" valign="top" style="padding:7px;line-height:22px;">{{ucfirst($guestsInfo->title)}} </td>
                  <td width="33%" valign="top" style="padding:7px;line-height:22px;">{{ucfirst($guestsInfo->first_name)}}</td>
                  <td width="33%" valign="top" style="padding:7px;line-height:22px;">{{ucfirst($guestsInfo->last_name)}} </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            
          </td>
        </tr>

        <tr>
          <td style="padding:25px 20px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">Room Details</h3></td>
        </tr>
        <tr>
          <td class="tablepadding" style="padding:20px 20px;"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
              <thead>
                <tr>
                  <td style="font-size:13px;border-right:1px solid #dddddd;background-color:#f8f8fa;font-weight:bold;padding:10px 7px;color:#505050">Plan</td>
                  <td style="font-size:13px; border-right:1px solid #dddddd;background-color:#f8f8fa;font-weight:bold;padding:10px 7px;color:#505050">Booking Code</td>
                  <td style="font-size:13px; background-color:#f8f8fa;font-weight:bold;padding:10px 7px;color:#505050">Meal Type</td>
                </tr>
              </thead>
              <tbody>
                  @foreach($result['hotel_booking_Details']->hotelroomBookingInfo as $roomInfo)
                <tr>
                  <td width="33%" valign="top" style="padding:7px;line-height:22px;">{{ucfirst($roomInfo->room_name)}} </td>
                  <td width="33%" valign="top" style="padding:7px;line-height:22px;">{{$roomInfo->booking_reference_no}}</td>
                  <td width="33%" valign="top" style="padding:7px;line-height:22px;">{{ucfirst($roomInfo->meal_type)}} </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </td>
        </tr>
        @if(!empty($result['cancellation_rules']))
          <tr>
            <td style="padding:10px 20px;"><h3 style="margin:0; font-weight:normal; color:#444444;">Cancellation Policies</h3></td>
          </tr>
          @foreach ($result['cancellation_rules'] as $roomKey => $roomCancellation_rules)
            <tr>
              <td style="padding: 10px 40px;"><h3 style="margin:0; font-weight:normal; color:#444444;">Room {{ $roomKey + 1 }}</h3></td>
            </tr>
            <tr>
              <td class="tablepadding" style="padding:0px 20px 15px;">
                <table style="border-collapse:collapse;width:100%;">
                  <tbody>
                    @foreach ($roomCancellation_rules['rules'] as $key => $cancellation_rule)
                      <tr>
                        <td align="right" valign="top" width="7%" style="font-size:16px; padding:5px; color:#666666;">&bull;</td>
                        <td style="font-size:13px; padding:5px 7px;">{{ $cancellation_rule }}</td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                </table></td>
            </tr>
              
          @endforeach
          
        @endif

        @if(!empty($result['excludedFees']))
          <tr>
            <td style="padding:10px 20px;"><h3 style="margin:0; font-weight:normal; color:#444444;">Excluded Fees</h3></td>
          </tr>
          <td class="tablepadding" style="padding:0px 20px 15px;">
            <table style="border-collapse:collapse;width:100%;">
              <tbody>
                @foreach ($result['excludedFees']['fees'] as $roomKey => $excludedFee)
                  <tr>
                    <td align="right" valign="top" width="7%" style="font-size:16px; padding:5px; color:#666666;">&bull;</td>
                    <td style="font-size:13px; padding:5px 7px;">{{ $excludedFee['display_text'] }}</td>
                  </tr>
                @endforeach
                </tbody>
            </table>
          </td>
        @endif
        
      </table></td>
  </tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#777777; font-family:Arial, Helvetica, sans-serif">
        <tbody>
          <tr>
            <td class="tablepadding" style="padding:20px 0; border-collapse:collapse">
            </td>
          </tr>
        </tbody>
      </table></td>
  </tr>
</table>
</body>
</html>