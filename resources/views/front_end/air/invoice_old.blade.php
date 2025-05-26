<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - 24Flights</title>
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
                      <td valign="top" align="left" style="padding: 9px 0px;"><a href="#"><img alt="" src="{{asset("frontEnd/images/logo.png")}}" style="padding-bottom: 0; display: inline !important;"></a></td>
                      <td valign="top" align="right" style="padding: 9px 0px;">
                        <div style="    width: 200px;">
                          <h4 style='font-size: 31px;font-weight: 600; color:#777;line-height:26px;margin: 0px; '>Invoice</h4>
                          <p style=" ">Invoice Number - {{$flightbookingdetails->invoice_id}}<p>
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
                      @if($flightbookingdetails->user_id)
                        {{$user}}
                      @endif
                      <address class="addressstyle">
                        {{$flightbookingdetails->email}}<br />
                        {{$flightbookingdetails->mobile}}<br />
                      </address>
                      </div></td>
                      <td style="font-size:14px;" align="right" width="50%"><div sclass=""> <strong>Pay To:</strong>
                        <address class="addressstyle">
                          24Flights (Al  Masila Int’l Travel & Tourism)<br />
                          Off 37, M1,  Sanabil Tower <br />
                          Sharq - Kuwait<br />
                          +965-22923004
                          </address>
                        </div></td>
                  </tr>
                  <tr>
                    <td style="font-size:14px;" align="left" width="50%"><div class=""> <strong>Payment method</strong>
                      <p style="margin-top: 0px">{{$flightbookingdetails->payment_gateway}}</p>
                    
                      </div></td>
                      <td style="font-size:14px;" align="right" width="50%"><div class=""> <strong>Booking date:</strong>
                        <p style="margin-top: 0px">{{date('d-m-Y', strtotime($flightbookingdetails->created_at))}}</p>
                        </div></td>
           
                  </tr>
                </tbody>
              </table></td>
            </tr>
          
            <tr>
              <td style="padding:25px 0px 0px;"><h3 style="margin:0; font-weight:normal; color:#444444;">
                Booking Summary
                </h3></td>
            </tr>
            {{-- <tr>
              <td class="tablepadding" style="padding:20px 0px 25px;"><table class="" style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;;border-right:1px solid #dddddd;">
                  <thead>
                    <tr>
                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Flight</td>
                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Basefare</td>
                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">tax</td>
                      <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Amount</td>
                      
                    </tr>
  
                  </thead>
                  <tbody>
                    <tr>
                      <td width="55%" valign="center" style="border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;border-right:1px solid #dddddd;"><span class="text-3"><span class="fw-500">Indigo 6E-2726</span> - Delhi to Sydney</span> <br>
                        Travel Date - Sat, 15 Jun 19, 01:50 hrs <br>
                        Neil Patel </td>
                      <td width="15%" valign="center" rowspan = "2" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> KWD 123
                      </td>
                      <td width="15%" valign="center" rowspan = "2" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> KWD 123
                      </td>
                      <td width="15%" valign="center" rowspan = "2"  style="border-right:1px solid #dddddd;border-left:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> KWD 123
                      </td>
                    </tr>
                    <tr>
                      <td width="60%" valign="center" style="border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;border-right:1px solid #dddddd;"><span class="text-3"><span class="fw-500">Indigo 6E-2726</span> - Delhi to Sydney</span> <br>
                        Travel Date - Sat, 15 Jun 19, 01:50 hrs <br>
                        Neil Patel </td>
                    </tr>
                    <tr>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3" align="right">
                       <strong>subtotal</strong> </td>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" >KWd 123</td>
                    </tr>
                    <tr>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3" align="right">discount</td>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3">KWd 123</td>
                    
                    </tr>
                    <tr>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3" align="right">total</td>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3">KWd 123</td>
                    
                    </tr>
  
                  </tbody>
                </table></td>
            </tr> --}}
  
            <tr>
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
                    @foreach ($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] as $k=>$airsegment)
                    <tr>
                      <td width="55%" valign="middle" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{$airsegment['@attributes']['airLineDetais']->name .' '.$airsegment['@attributes']['Carrier'].'-'. $airsegment['@attributes']['FlightNumber']}} -{{$airsegment['@attributes']['OriginAirportDetails']->city_name .' to '.$airsegment['@attributes']['DestinationAirportDetails']->city_name }} <br>
                        Travel Date (From) - {{date('d M D Y', strtotime(DateTimeSpliter($airsegment['@attributes']['DepartureTime'],"date")))}} , {{DateTimeSpliter($airsegment['@attributes']['DepartureTime'],"time")}} <br>
                        Travel Date (To)- {{date('d M D Y', strtotime(DateTimeSpliter($airsegment['@attributes']['ArrivalTime'],"date")))}} , {{DateTimeSpliter($airsegment['@attributes']['ArrivalTime'],"time")}}</td>
                        @if($k == 0)
                        <td width="15%" valign="middle"  rowspan="{{count($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] )}}"  align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$flightbookingdetails->currency_code .' '.$flightbookingdetails->basefare}} </td>
                      <td width="15%" valign="middle"  rowspan="{{count($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] )}}"  align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;">{{$flightbookingdetails->currency_code .' '.$flightbookingdetails->tax}} </td>
                      <td width="15%" valign="middle"  rowspan="{{count($response['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] )}}"  align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> {{$flightbookingdetails->currency_code .' '.$flightbookingdetails->sub_total}} </td>
                      @endif
                    </tr>
                    
  
                    @endforeach
  
                    <tr>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3" align="right">
                       <strong>Sub Total:</strong> </td>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" >{{$flightbookingdetails->currency_code .' '.$flightbookingdetails->sub_total}}</td>
                    </tr>
                    <tr>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3" align="right">
                       <strong>Promotional Code:</strong> </td>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" >-{{$flightbookingdetails->currency_code .' 0.000'}}</td>
                    </tr>
                    <tr>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" colspan="3" align="right">
                       <strong>Total:</strong> </td>
                      <td style="font-size:13px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777" >{{$flightbookingdetails->currency_code .' '.$flightbookingdetails->total_amount}}</td>
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
                      <td align="center" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Payment ID</td>
                      <td align="center" style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;padding:7px;color:#777777">Amount</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td width="25%" valign="top" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px;line-height:22px;">{{date('d-m-Y', strtotime($flightbookingdetails->created_at))}} </td>
                      <td width="25%" valign="top" align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> {{$flightbookingdetails->payment_gateway}} </td>
                      <td width="25%" valign="top" align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> {{$flightbookingdetails->payment_id}} </td>
                      <td width="25%" valign="top" align="center" style="border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;padding:7px;line-height:22px;"> {{$flightbookingdetails->currency_code .' '.$flightbookingdetails->total_amount}} </td>
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