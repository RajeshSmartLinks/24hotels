<?php

namespace App\Http\Controllers\Air;


use Attribute;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TravelportRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class BookingController extends Controller
{
    public function AirPricing($flightDetails,$UserRequest,$traceId)
    {
        $class = $UserRequest['flight-class'];
        // $trace_id  = $traceId;

        // if($UserRequest['flight-trip'] == 'roundtrip')
        // {
        //     $flightDetails['itinerary'] = [];
        //     $flightDetails['itinerary'] = array_merge($flightDetails['outboundItinerary'], $flightDetails['inboundItinerary']); 
        // }

        //Xml prepration
        $xml = <<<EOM
        <soapenv:Envelope xmlns:soapenv="$this->soapenvelope">
        <soapenv:Header/>
        EOM;
        $xml .=<<<EOM
        <soapenv:Body>
            <AirPriceReq xmlns="$this->airXmlns"  TargetBranch="$this->TragetBranch" TraceId="$traceId">
                <BillingPointOfSaleInfo xmlns="$this->commonXmlns" OriginApplication="uAPI" />
                <AirItinerary>
        EOM;
        if($UserRequest['flight-trip'] == 'roundtrip')
        {
            foreach($flightDetails['outboundItinerary'] as $OutKey=>$Outitinerary)
            {
                $AirSegment = $this->arrayValues($Outitinerary['AirSegment'] , 'airPricing');
        $xml .=<<<EOM
                
                    <AirSegment  $AirSegment>
        EOM;  
                        foreach($flightDetails['airOutConnectionsIndex'] as $airOutConnectionsIndexKey => $airOutConnectionsIndexValue )
                        {
                            if(isset($airOutConnectionsIndexValue['@attributes']) && $airOutConnectionsIndexValue['@attributes']['SegmentIndex'] == $OutKey)
                            {
        $xml .=<<<EOM
                        <Connection/>
        EOM;   
                            }
                        }
        $xml .=<<<EOM
                    </AirSegment>
        EOM;    
            }
            foreach($flightDetails['inboundItinerary'] as $InKey=>$Initinerary)
            {
                
                $AirSegment = $this->arrayValues($Initinerary['AirSegment'] , 'airPricing');
        $xml .=<<<EOM
                    <AirSegment  $AirSegment>
        EOM;  
                        foreach($flightDetails['airInConnectionsIndex'] as $airInConnectionsIndexKey => $airInConnectionsIndexValue )
                        {
                            if(isset($airInConnectionsIndexValue['@attributes']) && $airInConnectionsIndexValue['@attributes']['SegmentIndex'] == $InKey)
                            {
        $xml .=<<<EOM
                        <Connection/>
        EOM;   
                            }
                        }
        $xml .=<<<EOM
                    </AirSegment>
        EOM;    
            }
        }
        else{
            foreach($flightDetails['itinerary'] as $ItineraryKey=>$itinerary)
            {
                $AirSegment = $this->arrayValues($itinerary['AirSegment'] , 'airPricing');
        $xml .=<<<EOM
                
                    <AirSegment  $AirSegment>
        EOM;  
                    foreach($flightDetails['airConnectionsIndex'] as $airConnectionsIndexKey => $airConnectionsIndexValue )
                    {
                        if(isset($airConnectionsIndexValue['@attributes']) && $airConnectionsIndexValue['@attributes']['SegmentIndex'] == $ItineraryKey)
                        {
        $xml .=<<<EOM
                        <Connection/>
        EOM;
                            }
                        }
        $xml .=<<<EOM
                    </AirSegment>
        EOM;    
            }
        }
       
        $xml .=<<<EOM
                </AirItinerary>
                <AirPricingModifiers InventoryRequestType="DirectAccess"  SellCheck="true" FaresIndicator="AllFares">
                    <PermittedCabins>
                        <CabinClass xmlns="$this->commonXmlns" Type="$class" />
                    </PermittedCabins>
                    <BrandModifiers ModifierType="FareFamilyDisplay" />
                </AirPricingModifiers>
        EOM;
        for($i = 1 ; $i <=$UserRequest['noofAdults'] ; $i++ )
        {
            $key = $BookingTravelerRef = $traceId.'ADT'.$i;
            $xml .=<<<EOM
                <SearchPassenger xmlns="$this->commonXmlns" Code="ADT" BookingTravelerRef = "$BookingTravelerRef"/>
        EOM;
        }
        for($k = 1 ; $k <=$UserRequest['noofInfants'] ; $k++ )
        {
            $key = $BookingTravelerRef = $traceId.'INF'.$k;
            $xml .=<<<EOM
                <SearchPassenger xmlns="$this->commonXmlns" Code="INF" BookingTravelerRef = "$BookingTravelerRef" Age ="1"/>
        EOM;
        }
        for($j = 1 ; $j <=$UserRequest['noofChildren'] ; $j++ )
        {
            $key = $BookingTravelerRef = $traceId.'CNN'.$j;
            $xml .=<<<EOM
                <SearchPassenger xmlns="$this->commonXmlns" Code="CNN" BookingTravelerRef = "$BookingTravelerRef" Age ="10"/>
        EOM;
        }
        $xml .=<<<EOM
                <AirPricingCommand>
        EOM;  
        if($UserRequest['flight-trip'] == 'roundtrip')
        {
            $flightDetails['itinerary'] = [];
            $flightDetails['itinerary'] = array_merge($flightDetails['outboundItinerary'], $flightDetails['inboundItinerary']); 
        }      
        foreach($flightDetails['itinerary'] as $itinerary)
        {
            $AirSegmentRefKey =$itinerary['AirSegment']['Key'];
            $BookingCode =$itinerary['BookingCode'];
            $xml .=<<<EOM
                <AirSegmentPricingModifiers AirSegmentRef="$AirSegmentRefKey" >
                    <PermittedBookingCodes>
                        <BookingCode Code="$BookingCode" />
                    </PermittedBookingCodes>
                </AirSegmentPricingModifiers>
        EOM;
        }
        $xml .=<<<EOM
                </AirPricingCommand>
            </AirPriceReq>
        </soapenv:Body>
        </soapenv:Envelope>
        EOM;
        // dd($xml);
        $data = array(
            'xml' => $xml,
            'trace_id' => $traceId,
            'request_type' => 'airPricing'
        );
        $data = $this->TravelportAirApi($data);
        return $data;
    }

    public function AirCreateReservation($airPricingSolution , $request , $flightbookingdetails , $traceId)
    {
        $countryDetails = Country::find($flightbookingdetails->country_id);
        $phoneNumber = $flightbookingdetails->mobile;
        $email = $flightbookingdetails->email;
        $countryphoneCode = substr($countryDetails->phone_code,1);
        $carriers = array_column($airPricingSolution['airSegments'] , 'Carrier');
        $airPricingSolution = $airPricingSolution['air:AirPricingSolution'];
  
        // $traceId  = TravelportRequest::count() + 1;

        //Xml prepration
        $xml = <<<EOM
        <soapenv:Envelope xmlns:soapenv="$this->soapenvelope">
        <soapenv:Header/>
        EOM;
        $xml .=<<<EOM
        <soapenv:Body>
            <air:AirCreateReservationReq  TraceId="$traceId"  TargetBranch="$this->TragetBranch" ProviderCode="1G" RetainReservation="Both" xmlns:common_v52_0="$this->commonXmlns" xmlns:air="$this->universalXmlns">
                <com:BillingPointOfSaleInfo xmlns:com="$this->commonXmlns" OriginApplication="uAPI"/>
        EOM;
                $i = 1;
                $j = 1;
                $k = 1;
                $appLanguage = Config::get('app.locale');
                Carbon::setLocale('en');
                foreach($request as $index => $travelersdetails)
                {
                    //$KeyValue = $index + 1 ;
                    $travelerType = $travelersdetails->traveler_type;
                    $title = $travelersdetails->title;
                    $firstName = $travelersdetails->first_name;
                    $lastName = $travelersdetails->last_name;
                    $dob = Carbon::create($travelersdetails->date_of_birth)->isoFormat('YYYY-MM-DD');
                    $ssrDob = strtoupper(Carbon::create($dob)->isoFormat('DDMMMYY'));
                    $ssrExipreDate = strtoupper(Carbon::create($travelersdetails->passport_expire_date)->isoFormat('DDMMMYY'));
                    
                    // $passportExpireDate = $travelersdetails->passport_expire_date;
                    $gender = $travelersdetails->gender;
                    $passportIssuedCountryCode = $travelersdetails->passportIssuedCountry->country_code ?? '';
                    $passportNumber = $travelersdetails->passport_number;



                    if($index == 0)
                    {
                        $phoneNumberAndEmailDetails = '<com:PhoneNumber  CountryCode="'.$countryphoneCode.'"  Number="'.$phoneNumber.'" /><com:Email EmailID="'.$email.'" />';
                    }
                    else
                    {
                        $phoneNumberAndEmailDetails = '';
                    }

                    

                    if($travelersdetails->traveler_type == "ADT"){
                        $key = $traceId."ADT".$i;
                        $ssrFreeText = "P/".$passportIssuedCountryCode."/".$passportNumber."/".$passportIssuedCountryCode."/".$ssrDob."/".$gender."/".$ssrExipreDate."/".strtoupper(str_replace(' ','',$firstName))."/".strtoupper(str_replace(' ','',$lastName));
                      
        $xml .=<<<EOM
                <com:BookingTraveler xmlns:com="$this->commonXmlns" Key="$key" TravelerType="$travelerType" Gender="$gender" DOB = "$dob" >
                    <com:BookingTravelerName Prefix="$title" First="$firstName" Last="$lastName" />
                    $phoneNumberAndEmailDetails
                    <com:SSR Type="DOCS" FreeText="$ssrFreeText"/>
        EOM;
      
        if(in_array('TK',$carriers)){
            $phoneNumber = $phoneNumber;
            $emailID = ssremailformater($email);
        $xml .=<<<EOM
                    <com:SSR Carrier="TK" FreeText="$phoneNumber" Type="CTCM"/>
                    <com:SSR Carrier="TK" FreeText="$emailID" Type="CTCE"/>
        EOM;

        }
        $xml .=<<<EOM
                </com:BookingTraveler>
        EOM;  
                        $i++;
                    }
                    elseif($travelersdetails->traveler_type == "INF")
                    {
                        $key = $traceId."INF".$k;
                        $ssrGender = ($gender == 'M') ? 'MI' : 'FI';
                        $ssrFreeText = "P/".$passportIssuedCountryCode."/".$passportNumber."/".$passportIssuedCountryCode."/".$ssrDob."/".$ssrGender."/".$ssrExipreDate."/".strtoupper(str_replace(' ','',$firstName))."/".strtoupper(str_replace(' ','',$lastName));
                        
        $xml .=<<<EOM
                <com:BookingTraveler xmlns:com="$this->commonXmlns" Key="$key" TravelerType="$travelerType" Gender="$gender"  DOB="$dob">
                    <com:BookingTravelerName Prefix="$title" First="$firstName" Last="$lastName" />
                    $phoneNumberAndEmailDetails
                    <com:SSR Type="DOCS" FreeText="$ssrFreeText"/>
                    <com:NameRemark>
                        <com:RemarkData>$ssrDob</com:RemarkData>
                    </com:NameRemark>
                </com:BookingTraveler>
        EOM;  
                        $k++;
                    }
                    elseif($travelersdetails->traveler_type == "CNN"){
                        $key = $traceId."CNN".$j;
                        $nameRemarkage = Carbon::parse($travelersdetails->date_of_birth)->age;
                        $nameRemarkage = ($nameRemarkage < 10) ? "0".$nameRemarkage : $nameRemarkage ;
                        $ssrFreeText = "P/".$passportIssuedCountryCode."/".$passportNumber."/".$passportIssuedCountryCode."/".$ssrDob."/".$gender."/".$ssrExipreDate."/".strtoupper(str_replace(' ','',$firstName))."/".strtoupper(str_replace(' ','',$lastName));
        $xml .=<<<EOM
                <com:BookingTraveler xmlns:com="$this->commonXmlns" Key="$key" TravelerType="$travelerType" Gender="$gender"  DOB="$dob">
                    <com:BookingTravelerName Prefix="$title" First="$firstName" Last="$lastName" />
                    $phoneNumberAndEmailDetails
                    <com:SSR Type="DOCS" FreeText="$ssrFreeText"/>
                    <com:NameRemark>
                        <com:RemarkData>P-C$nameRemarkage DOB$ssrDob </com:RemarkData>
                    </com:NameRemark>
                </com:BookingTraveler>
        EOM;  
                        $j++;
                    }
                }
                Carbon::setLocale($appLanguage);
                $airPricingSolutionKey = $airPricingSolution['@attributes']['Key'];
                $TotalPrice = $airPricingSolution['@attributes']['TotalPrice'];
                $BasePrice = $airPricingSolution['@attributes']['BasePrice'];
                $ApproximateTotalPrice = $airPricingSolution['@attributes']['ApproximateTotalPrice'];
                $ApproximateBasePrice = $airPricingSolution['@attributes']['ApproximateBasePrice'];
                //$EquivalentBasePrice = $airPricingSolution['@attributes']['EquivalentBasePrice'];
                // <air:AirPricingSolution xmlns:air="$this->airXmlns" Key="$airPricingSolutionKey" TotalPrice="$TotalPrice" BasePrice="$BasePrice" ApproximateTotalPrice="$ApproximateTotalPrice" ApproximateBasePrice="$ApproximateBasePrice" EquivalentBasePrice="$EquivalentBasePrice" Taxes="$Taxes" Fees="$Fees">
                $Taxes = $airPricingSolution['@attributes']['Taxes'];
                $Fees = $airPricingSolution['@attributes']['Fees'];
        $xml .=<<<EOM
                <com:FormOfPayment xmlns:com="$this->commonXmlns" Type="Cash" Key="1">
                </com:FormOfPayment>
                <air:AirPricingSolution xmlns:air="$this->airXmlns" Key="$airPricingSolutionKey" TotalPrice="$TotalPrice" BasePrice="$BasePrice" ApproximateTotalPrice="$ApproximateTotalPrice" ApproximateBasePrice="$ApproximateBasePrice" Taxes="$Taxes" Fees="$Fees">
        EOM;
        foreach ($airPricingSolution['AirSegment'] as $key => $value) 
        {
            // $airSegmentKey = $value['@attributes']['Key'];
            // $OptionalServicesIndicator = $value['@attributes']['OptionalServicesIndicator'];
            // $AvailabilityDisplayType = $value['@attributes']['AvailabilityDisplayType'];
            // $Group = $value['@attributes']['Group'];
            // $Carrier = $value['@attributes']['Carrier'];
            // $FlightNumber = $value['@attributes']['FlightNumber'];
            // $Origin = $value['@attributes']['Origin'];
            // $Destination = $value['@attributes']['Destination'];
            // $DepartureTime = $value['@attributes']['DepartureTime'];
            // $ArrivalTime = $value['@attributes']['ArrivalTime'];
            // $FlightTime = $value['@attributes']['FlightTime'];
            // $TravelTime = $value['@attributes']['TravelTime'];
            // $Distance = $value['@attributes']['Distance'];
            // $ProviderCode = $value['@attributes']['ProviderCode'];
            // $ClassOfService = $value['@attributes']['ClassOfService'];
            // <air:AirSegment Key="$airSegmentKey" OptionalServicesIndicator="$OptionalServicesIndicator" AvailabilityDisplayType="$AvailabilityDisplayType" Group="$Group" Carrier="$Carrier" FlightNumber="$FlightNumber" Origin="$Origin" Destination="$Destination" DepartureTime="$DepartureTime" ArrivalTime="$ArrivalTime" FlightTime="$FlightTime" TravelTime="$TravelTime" Distance="$Distance" ProviderCode="$ProviderCode" ClassOfService="$ClassOfService">
            // <air:CodeshareInfo OperatingCarrier="$Carrier" />
            // </air:AirSegment>
   
            $AirSegment = $this->arrayValues($value['@attributes'] , 'airCreationReservation');
        $xml .=<<<EOM
                <air:AirSegment $AirSegment >
        EOM; 
        if(isset($value['air:Connection']))
        {
        $xml .=<<<EOM
                <air:Connection />
        EOM; 

        }
        $xml .=<<<EOM
                </air:AirSegment>
        EOM; 

        }
        //dd($airPricingSolution['air:AirPricingInfo']);
        if(isset($airPricingSolution['air:AirPricingInfo']['@attributes']))
        {
            $PricingSolution = $airPricingSolution['air:AirPricingInfo'];
            $airPricingSolution['air:AirPricingInfo'] = [];
            $airPricingSolution['air:AirPricingInfo'][0] = $PricingSolution;
        }
        
        foreach ($airPricingSolution['air:AirPricingInfo'] as $key => $value) 
        {
            
            $airPricingInfoKey = $value['@attributes']['Key'];
            $PricingMethod = $value['@attributes']['PricingMethod'];
            $TotalPrice = $value['@attributes']['TotalPrice'];
            $BasePrice = $value['@attributes']['BasePrice'];
            $ApproximateTotalPrice = $value['@attributes']['ApproximateTotalPrice'];
            $ApproximateBasePrice = $value['@attributes']['ApproximateBasePrice'];
            $Taxes = $value['@attributes']['Taxes'];
            $ProviderCode = $value['@attributes']['ProviderCode'];
           
        $xml .=<<<EOM
                <air:AirPricingInfo PricingMethod="$PricingMethod" Key="$airPricingInfoKey" TotalPrice="$TotalPrice" BasePrice="$BasePrice" ApproximateTotalPrice="$ApproximateTotalPrice" ApproximateBasePrice="$ApproximateBasePrice" Taxes="$Taxes" ProviderCode="$ProviderCode">
        EOM;
            if(isset($value['air:FareInfo']['@attributes']))
            {
                $fareInfo = $value['air:FareInfo'];
                $value['air:FareInfo'] = [];
                $value['air:FareInfo'][0] = $fareInfo;
            }

            foreach($value['air:FareInfo'] as $fareInfo)
            {
                $FareInfoKey = $fareInfo['@attributes']['Key'];
                $DepartureDate = $fareInfo['@attributes']['DepartureDate'];
                $Amount = $fareInfo['@attributes']['Amount'];
                $EffectiveDate = $fareInfo['@attributes']['EffectiveDate'];
                $Destination = $fareInfo['@attributes']['Destination'];
                $Origin = $fareInfo['@attributes']['Origin'];
                $PassengerTypeCode = $fareInfo['@attributes']['PassengerTypeCode'];
                $FareBasis = $fareInfo['@attributes']['FareBasis'];
                $airFareRuleKey = $fareInfo['air:FareRuleKey']['@content'];
        $xml .=<<<EOM
                    <air:FareInfo  DepartureDate="$DepartureDate" Amount="$Amount" EffectiveDate="$EffectiveDate" Destination="$Destination" Origin="$Origin" PassengerTypeCode="$PassengerTypeCode" FareBasis="$FareBasis" Key="$FareInfoKey">
                        <air:FareRuleKey FareInfoRef="$FareInfoKey" ProviderCode="$ProviderCode">$airFareRuleKey</air:FareRuleKey>
                    </air:FareInfo>
        EOM;

            }
            
            if(isset($value['air:BookingInfo']['@attributes']))
            {
                $BookingCode = $value['air:BookingInfo']['@attributes']['BookingCode'];
                $CabinClass = $value['air:BookingInfo']['@attributes']['CabinClass'];
                $FareInfoRef = $value['air:BookingInfo']['@attributes']['FareInfoRef'];
                $SegmentRef = $value['air:BookingInfo']['@attributes']['SegmentRef'];
                $HostTokenRef = $value['air:BookingInfo']['@attributes']['HostTokenRef'];
                $hostKeys[] = $HostTokenRef;
        $xml .=<<<EOM
                    <air:BookingInfo BookingCode="$BookingCode" CabinClass="$CabinClass" FareInfoRef="$FareInfoRef" SegmentRef="$SegmentRef" HostTokenRef="$HostTokenRef" />
        EOM;
            }
            else{
                foreach($value['air:BookingInfo'] as $bokingInfo)
                {
                    $BookingCode = $bokingInfo['@attributes']['BookingCode'];
                    $CabinClass = $bokingInfo['@attributes']['CabinClass'];
                    $FareInfoRef = $bokingInfo['@attributes']['FareInfoRef'];
                    $SegmentRef = $bokingInfo['@attributes']['SegmentRef'];
                    $HostTokenRef = $bokingInfo['@attributes']['HostTokenRef'];
        $xml .=<<<EOM
                    <air:BookingInfo BookingCode="$BookingCode" CabinClass="$CabinClass" FareInfoRef="$FareInfoRef" SegmentRef="$SegmentRef" HostTokenRef="$HostTokenRef" />
        EOM;
                    
                }
            }
            if(isset($value['air:TaxInfo']['@attributes']))
            {
                $temp = $value['air:TaxInfo'] ; 
                $value['air:TaxInfo'] = [];
                $value['air:TaxInfo'][0] = $temp;
            }

            foreach ($value['air:TaxInfo'] as $Tax) {
                $Amount = $Tax['@attributes']['Amount'];
                $Category = $Tax['@attributes']['Category'];
                $TaxKey = $Tax['@attributes']['Key'];
        $xml .=<<<EOM
                    <air:TaxInfo Amount="$Amount" Category="$Category" Key="$TaxKey" />
        EOM;
                
            }
            // foreach($request as $travelersdetails)
            // {
            //     $BookingTravelerRef = $travelersdetails->traveler_type.'-'.$travelersdetails->id;
            //     $travelerType = $travelersdetails->traveler_type;
            //     $xml .=<<<EOM

            //     <air:PassengerType Code="$travelerType" BookingTravelerRef="$BookingTravelerRef" />
            //     EOM;  
            // }

            if(isset($value['air:PassengerType']['@attributes']))
            {
                $PassengerCode = $value['air:PassengerType']['@attributes']['Code'];
                if($PassengerCode == "ADT")
                {
                   $BookingTravelerRef = $traceId."ADT1"; 
                }
                elseif($PassengerCode == "CNN")
                {
                    $BookingTravelerRef = $traceId."CNN1";
                }
                else{
                    $BookingTravelerRef = $traceId."INF1"; 
                }
                if($PassengerCode == "CNN" || $PassengerCode == "INF")
                {

                    $filtered = $request->search(function($item) use ($BookingTravelerRef) {
                        return stripos($item['traveler_ref_id'],$BookingTravelerRef) !== false;
                    });

                    $INFage = (Carbon::parse($request[$filtered]['date_of_birth'])->age < 1) ? 1 :Carbon::parse($request[$filtered]['date_of_birth'])->age;
                    
                    $age = (!empty($filtered)) ? 'Age = "'.$INFage.'"' : '' ;
                }
                else{
                    $age = '';
                }
        $xml .=<<<EOM
                        <air:PassengerType Code="$PassengerCode" BookingTravelerRef="$BookingTravelerRef" $age/>
        EOM;
            }
            else{
                foreach($value['air:PassengerType'] as $Pk=>$passenger)
                {
                    $PassengerCode = $passenger['@attributes']['Code'];
                    if($PassengerCode == "ADT")
                    {
                    $BookingTravelerRef = $traceId."ADT".($Pk+1); 
                    }
                    elseif($PassengerCode == "CNN")
                    {
                        $BookingTravelerRef = $traceId."CNN".($Pk+1);
                    }
                    else{
                        $BookingTravelerRef = $traceId."INF".($Pk+1);
                    }
                    if($PassengerCode == "CNN" || $PassengerCode == "INF")
                    {
    
                        $filtered = $request->search(function($item) use ($BookingTravelerRef) {
                            return stripos($item['traveler_ref_id'],$BookingTravelerRef) !== false;
                        });
                        //$age = (!empty($filtered)) ? 'Age = "'.Carbon::parse($request[$filtered]['date_of_birth'])->age.'"' : '' ;
                        $INFage = (Carbon::parse($request[$filtered]['date_of_birth'])->age < 1) ? 1 :Carbon::parse($request[$filtered]['date_of_birth'])->age;
                    
                        $age = (!empty($filtered)) ? 'Age = "'.$INFage.'"' : '' ;
                    }
                    else{
                        $age = '';
                    }
        $xml .=<<<EOM
                        <air:PassengerType Code="$PassengerCode" BookingTravelerRef="$BookingTravelerRef" $age />
        EOM; 
                }
            }

        $xml .=<<<EOM
                <air:AirPricingModifiers  FaresIndicator="AllFares" />
                </air:AirPricingInfo>
        EOM;
        }
        // if(!is_array($airPricingSolution['common_v52_0:HostToken']))
        // {
        //     $HostToken = $airPricingSolution['common_v52_0:HostToken'];
        //     $airPricingSolution['common_v52_0:HostToken'] = [];
        //     $airPricingSolution['common_v52_0:HostToken'][0] = $HostToken;

        // }
        if(isset($airPricingSolution['common_v52_0:HostToken']['@attributes']))
        {
            $hostKey = $airPricingSolution['common_v52_0:HostToken']['@attributes']['Key'];
            $HostToken = $airPricingSolution['common_v52_0:HostToken']['@content'];
            $xml .=<<<EOM
                            <common_v52_0:HostToken xmlns:com="$this->commonXmlns" Key="$hostKey">$HostToken</common_v52_0:HostToken>
                EOM;
        }
        else{
            foreach($airPricingSolution['common_v52_0:HostToken'] as $HostTokenDetails)
            {
                $hostKey = $HostTokenDetails['@attributes']['Key'];
                $HostToken = $HostTokenDetails['@content'];
                $xml .=<<<EOM
                            <common_v52_0:HostToken xmlns:com="$this->commonXmlns" Key="$hostKey">$HostToken</common_v52_0:HostToken>
                EOM;
            }
        }
        $xml .=<<<EOM
                </air:AirPricingSolution>
                <com:ActionStatus xmlns:com="$this->commonXmlns" Type="ACTIVE" TicketDate="T*" ProviderCode="1G" />
                <com:Payment xmlns:com="$this->commonXmlns" Key="2" Type="Itinerary" FormOfPaymentRef="1" Amount="$TotalPrice" />
            </air:AirCreateReservationReq>
        </soapenv:Body>
        </soapenv:Envelope>
        EOM;

        $data = array(
            'xml' => $xml,
            'trace_id' => $traceId,
            'request_type' => 'booking',
        );
        // dd($xml);
        $data = $this->TravelportAirApi($data);
        // return [
        //     'response' => $data,
        //     'trace_id' => $trace_id
        // ];
        return $data;
    }

    public function FareRules($airPricing , $traceId)
    {
        //print_r($airPricing['air:AirPricingSolution']['air:AirPricingInfo']);

        $xml = <<<EOM
        <soapenv:Envelope xmlns:soapenv="$this->soapenvelope">
        <soapenv:Header/>
        EOM;
        $xml .=<<<EOM
        <soapenv:Body>
            <AirFareRulesReq xmlns="$this->airXmlns"  TargetBranch="$this->TragetBranch" TraceId="$traceId">
                <BillingPointOfSaleInfo xmlns="$this->commonXmlns" OriginApplication="uAPI" />
        EOM;
        foreach($airPricing['air:AirPricingSolution']['air:AirPricingInfo'] as $key => $value) {

            foreach($airPricing['air:AirPricingSolution']['air:AirPricingInfo'][$key]['air:FareInfo'] as $FareInfokey => $FareInfovalue)
            {
                $FareInfoRef = $FareInfovalue['air:FareRuleKey']['@attributes']['FareInfoRef'];
                $ProviderCode = $FareInfovalue['air:FareRuleKey']['@attributes']['ProviderCode'];
                $refCode = $FareInfovalue['air:FareRuleKey']['@content'];
                $xml .=<<<EOM
                <FareRuleKey FareInfoRef="$FareInfoRef" ProviderCode="$ProviderCode">$refCode</FareRuleKey>
                EOM;

            }

            // $FareInfoRef = $value['air:FareInfo']['air:FareRuleKey']['@attributes']['FareInfoRef'];
            // $ProviderCode = $value['air:FareInfo']['air:FareRuleKey']['@attributes']['ProviderCode'];
            // $refCode = $value['air:FareInfo']['air:FareRuleKey']['@content'];
            
       
        }
        $xml .=<<<EOM
                </AirFareRulesReq>
            </soapenv:Body>
            </soapenv:Envelope>
            EOM;
        //Sdd($xml);
        $data = array(
            'xml' => $xml,
            'trace_id' => $traceId,
            'request_type' => 'farerule'
        );
        $data = $this->TravelportAirApi($data);
        return $data;

    }

    public function arrayValues($array , $type)
    {
        $itinerary = "";
        foreach($array as $k => $value)
        {
            if($k == 'OriginAirportDetails' || $k == 'DestationAirportDetails' || $k == 'airline' )
            {
                continue ;
            }
            $itinerary .= $k . ' = "'.$value.'" ';
        }
        if($type == "airPricing")
        {
            $itinerary .= 'ProviderCode = "1G"';
        }
        
        return $itinerary;

    }

    public function OnlineTicketing($univeralReservation , $traceId)
    {

        //Xml prepration
        $xml = <<<EOM
        <soapenv:Envelope xmlns:soapenv="$this->soapenvelope">
            <soapenv:Header/>
        EOM;
        $ReservationCode = $univeralReservation['universal:UniversalRecord']['air:AirReservation']['@attributes']['LocatorCode'] ;
        $xml .=<<<EOM
            <soapenv:Body>
                <AirTicketingReq xmlns="$this->airXmlns" TargetBranch="$this->TragetBranch">
                    <BillingPointOfSaleInfo xmlns="$this->commonXmlns" OriginApplication="UAPI" />
                    <AirReservationLocatorCode>$ReservationCode</AirReservationLocatorCode>
        EOM;
        foreach ($univeralReservation['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] as $AirPricingInfokey => $AirPricingInfovalue) {
            $AirPricingInfoRef = $AirPricingInfovalue['@attributes']['Key'];
            $xml .= <<<EOM
                                <AirPricingInfoRef Key="$AirPricingInfoRef" />
                    EOM;
        }
        $xml .= <<<EOM
                </AirTicketingReq>
            </soapenv:Body>
        </soapenv:Envelope>
        EOM;

        $data = array(
            'xml' => $xml,
            'trace_id' => $traceId,
            'request_type' => 'ticketing',
        );
        // dd($xml);
        $data = $this->TravelportAirApi($data);
        return $data;
    } 

    public function AirArabiaPricing($flightDetails,$UserRequest,$traceId,$extraInfo=[])
    {
        $transactionIdentifier = $flightDetails['transactionIdentifier'];

        //Xml Prepration
        $xml = <<<EOM
        <soap:Envelope xmlns:soap="$this->soapenvelope" xmlns:xsd="$this->w3Org" xmlns:xsi="$this->w3Org-instance">
        <soap:Header>
            <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken wsu:Id="UsernameToken-17855236" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <wsse:Username>$this->AirArabiaUsername</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">$this->AirArabiaPassword</wsse:Password>
            </wsse:UsernameToken>
            </wsse:Security>
        </soap:Header>
        EOM;

        $DirectionInd = ($UserRequest['flight-trip'] == 'roundtrip') ? 'Return' : 'OneWay';

        $xml .=<<<EOM
        <soap:Body  xmlns:ns1="http://www.opentravel.org/OTA/2003/05">
            <ns1:OTA_AirPriceRQ EchoToken="11868765275150-1300257933" PrimaryLangID="en-us" SequenceNmbr="1" Target="TEST" TimeStamp="2023-01-09T04:55:27" Version="20061.00" TransactionIdentifier="$transactionIdentifier">
            <ns1:POS>
                <ns1:Source TerminalID="TestUser/Test Runner">
                <ns1:RequestorID ID="$this->AirArabiaUsername" Type="4" />
                <ns1:BookingChannel Type="12" />
                </ns1:Source>
            </ns1:POS>
            <ns1:AirItinerary DirectionInd="$DirectionInd">
                <ns1:OriginDestinationOptions>
        EOM;
        if($UserRequest['flight-trip'] == 'roundtrip')
        {
            $flightDetails['itinerary'] = array_merge($flightDetails['outboundItinerary'],$flightDetails['inboundItinerary']);
        }
     

        foreach ($flightDetails['itinerary'] as $itkey => $itvalue) {
            if(isset($itvalue['from']) && $itvalue['from'] == 'mobile')
            {
                $itvalue['airarabiaData'] =json_decode($itvalue['airarabiaData'],true);
            }
            $FlightSegment = $this->arrayValues($itvalue['AirSegment']['ns1:FlightSegment']['@attributes'] , '');
            $DepartureAirport = $this->arrayValues($itvalue['AirSegment']['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes'] , '');
            $ArrivalAirport = $this->arrayValues($itvalue['AirSegment']['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes'] , '');
        $xml .=<<<EOM
                    <ns1:OriginDestinationOption>
                        <ns1:FlightSegment  $FlightSegment >
                        <ns1:DepartureAirport $DepartureAirport />
                        <ns1:ArrivalAirport $ArrivalAirport />
                        </ns1:FlightSegment>
                    </ns1:OriginDestinationOption>
        EOM;
        }
        
        $xml .=<<<EOM
                </ns1:OriginDestinationOptions>
            </ns1:AirItinerary>
            <ns1:TravelerInfoSummary>
                <ns1:AirTravelerAvail>
        EOM; 
        

        if(isset($UserRequest['noofAdults']) && ($UserRequest['noofAdults']) > 0)
        {
            $noofAdults = $UserRequest['noofAdults'] ;
            $xml .=<<<EOM
                <ns1:PassengerTypeQuantity Code="ADT" Quantity="$noofAdults" />
        EOM;
        }   
        if(isset($UserRequest['noofChildren']) && ($UserRequest['noofChildren']) > 0)
        {
            $noofChildren = $UserRequest['noofChildren'] ;
            $xml .=<<<EOM
                <ns1:PassengerTypeQuantity Code="CHD" Quantity="$noofChildren" />
        EOM;
        }
        if(isset($UserRequest['noofInfants']) && ($UserRequest['noofInfants']) > 0)
        {
            $noofInfants = $UserRequest['noofInfants'] ;
            $xml .=<<<EOM
                <ns1:PassengerTypeQuantity Code="INF" Quantity="$noofInfants" />
        EOM;
        }
        $xml .=<<<EOM
                </ns1:AirTravelerAvail>
        EOM;
        //extra baggage
        if(isset($extraInfo['page_type']) && $extraInfo['page_type'] == 'preview')
        {
            
            if(isset($extraInfo['travelersInfo']))
            $xml .=<<<EOM
            <ns1:SpecialReqDetails>
                <ns1:BaggageRequests>
            EOM;
                foreach ($flightDetails['itinerary'] as $itkey => $itvalue) {
                    // if(isset($itvalue['from']) && $itvalue['from'] == 'mobile')
                    // {
                    //     $itvalue['airarabiaData'] =json_decode($itvalue['airarabiaData'],true);
                    // }
                    $FlightRefNumberRPHList = $itvalue['AirSegment']['ns1:FlightSegment']['@attributes']['RPH'];
                    $FlightNumber = $itvalue['AirSegment']['ns1:FlightSegment']['@attributes']['FlightNumber'];
                    $DepartureDate = $itvalue['AirSegment']['ns1:FlightSegment']['@attributes']['DepartureDateTime'];
                    if(isset($itvalue['AirSegment']['from']) && $itvalue['AirSegment']['from'] == 'mobile'){
                        //from mobile
                        if($itvalue['AirSegment']['segmentType'] == 'outbound')
                        {
                            $extraBaggageKey = 'depatureextrabaggage';
                        }
                        else{
                            $extraBaggageKey = 'returnextrabaggage';
                        }

                        foreach ($extraInfo['travelersInfo'] as $key => $value) {
                  
                            if($value['passengerType'] == 'ADT')
                            {
                                $TravelerRefNumberRPHList = 'A'.($key+1);
                            }
                            elseif($value['passengerType'] == 'CNN'){
                                $TravelerRefNumberRPHList = 'C'.($key+1);
                            }
                            else{
                                continue;
                            }

                            if(!isset($value[$extraBaggageKey])){
                                $extraBaggage = 'No Bag';
                            }
                            else
                            {
                                $extraBaggage = $value[$extraBaggageKey];
                            }
                            $xml .=<<<EOM
                            <ns1:BaggageRequest baggageCode="$extraBaggage" TravelerRefNumberRPHList="$TravelerRefNumberRPHList" FlightRefNumberRPHList="$FlightRefNumberRPHList" DepartureDate="$DepartureDate" FlightNumber="$FlightNumber"/>
                            EOM;
                        }
                    }
                    else
                    {
                        if($itvalue['AirSegment']['segmentType'] == 'outbound')
                        {
                            $adultfieldname = 'adultdepatureextrabaggage';
                            $childfieldname = 'childrendepatureextrabaggage';
                        }
                        else{
                            $adultfieldname = 'adultreturnextrabaggage';
                            $childfieldname = 'childrenreturnextrabaggage';
                        }

                        if(isset($extraInfo['travelersInfo']['Depaturebaggage']) && $itvalue['AirSegment']['segmentType'] == 'outbound')
                        {
                            $dadult = 1;
                            // $dchild = 1;
                            foreach ($extraInfo['travelersInfo']['Depaturebaggage'] as $key => $value) {
                                for ($dg=0; $dg < (int)$value; $dg++) { 
                                    if($UserRequest['noofAdults'] >= $dadult)
                                    {
                                        $TravelerRefNumberRPHList = 'A'.($dadult);
                                        $dadult++;
                                    }
                                    else{
                                           //after completion of adult statring child count
                                        $TravelerRefNumberRPHList = 'C'.($dadult);
                                        $dadult++;
                                    }
                                    $xml .=<<<EOM
                                        <ns1:BaggageRequest baggageCode="$key" TravelerRefNumberRPHList="$TravelerRefNumberRPHList" FlightRefNumberRPHList="$FlightRefNumberRPHList" DepartureDate="$DepartureDate" FlightNumber="$FlightNumber"/>
                                        EOM;
                                }
                            }
                        }
                        elseif(isset($extraInfo['travelersInfo']['Returnbaggage']))
                        {
                            $radult = 1;
                            $rchild = 1;
                            foreach ($extraInfo['travelersInfo']['Returnbaggage'] as $key => $value) {
                                for ($dg=0; $dg < (int)$value; $dg++) { 
                                    if($UserRequest['noofAdults'] >= $radult)
                                    {
                                        $TravelerRefNumberRPHList = 'A'.($radult);
                                        $radult++;
                                    }
                                    else{
                                           //after completion of adult statring child count
                                        $TravelerRefNumberRPHList = 'C'.($radult);
                                        $radult++;
                                    }
                                    $xml .=<<<EOM
                                        <ns1:BaggageRequest baggageCode="$key" TravelerRefNumberRPHList="$TravelerRefNumberRPHList" FlightRefNumberRPHList="$FlightRefNumberRPHList" DepartureDate="$DepartureDate" FlightNumber="$FlightNumber"/>
                                        EOM;
                                }
                            }
                        }
                    }
                }
                $xml .=<<<EOM
                </ns1:BaggageRequests>
            </ns1:SpecialReqDetails>
            EOM;
        }

        $xml .=<<<EOM
            </ns1:TravelerInfoSummary>
            </ns1:OTA_AirPriceRQ>
        </soap:Body>
        </soap:Envelope>   
        EOM; 
        //   dd($xml);
        $data = array(
            'xml' => $xml,
            'trace_id' => $traceId,
            'request_type' => 'airPricing',
            'transactionIdentifier' => $transactionIdentifier
        );
        $data = $this->AirArabiaApi($data);
        return $data;
    }


    //baggage
    public function AirArabiaBaggage($data)
    {
        $transactionIdentifier = $data['flightDetails']['transactionIdentifier'];

        //Xml Prepration
        $xml = <<<EOM
        <soap:Envelope xmlns:soap="$this->soapenvelope" xmlns:xsd="$this->w3Org" xmlns:xsi="$this->w3Org-instance">
        <soap:Header>
            <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken wsu:Id="UsernameToken-17855236" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <wsse:Username>$this->AirArabiaUsername</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">$this->AirArabiaPassword</wsse:Password>
            </wsse:UsernameToken>
            </wsse:Security>
        </soap:Header>
        EOM;

        $xml .=<<<EOM
        <soap:Body xmlns:ns="http://www.opentravel.org/OTA/2003/05">
            <ns:AA_OTA_AirBaggageDetailsRQ EchoToken="11835513529845-916011621" PrimaryLangID="en-us" SequenceNmbr="1" TransactionIdentifier="$transactionIdentifier" Version="2006.01">
            <ns:POS>
                <ns:Source TerminalID="TestUser/Test Runner">
                <ns:RequestorID ID="$this->AirArabiaUsername" Type="4" />
                <ns:BookingChannel Type="12" />
                </ns:Source>
            </ns:POS>
            <ns:BaggageDetailsRequests>
        EOM; 
        $newitinerary =[];
        if($data['UserRequest']['flight-trip'] == 'roundtrip')
        {
           foreach ($data['flightDetails']['airSegments'] as $key => $value) {
                if($data['bound'] == $value['segmentType'])
                {
                    $newitinerary[] = $value;
                }
           }
        }
        else{
            $newitinerary = $data['flightDetails']['airSegments'];
        }
        foreach ($newitinerary as $itkey => $itvalue) {
            if(isset($itvalue['from']) && $itvalue['from'] == 'mobile')
            {
                $itvalue['airarabiaData'] =json_decode($itvalue['airarabiaData'],true);
            }
            $FlightSegment = $this->arrayValues($itvalue['airarabiaData']['ns1:FlightSegment']['@attributes'] , '');
            $DepartureAirport = $this->arrayValues($itvalue['airarabiaData']['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes'] , '');
            $ArrivalAirport = $this->arrayValues($itvalue['airarabiaData']['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes'] , '');
            $xml .=<<<EOM
            <ns:BaggageDetailsRequest>
                <ns:FlightSegmentInfo  $FlightSegment >
                <ns:DepartureAirport $DepartureAirport />
                <ns:ArrivalAirport $ArrivalAirport />
                <ns:OperatingAirline Code="G9"/> 
                </ns:FlightSegmentInfo>
            </ns:BaggageDetailsRequest>

            EOM;     
        }

        $xml .=<<<EOM
                </ns:BaggageDetailsRequests>
            </ns:AA_OTA_AirBaggageDetailsRQ>
        </soap:Body>
        </soap:Envelope>   
        EOM; 
        $data = array(
            'xml' => $xml,
            'trace_id' => $data['traceId'],
            'request_type' => 'baggage',
            'transactionIdentifier' => $transactionIdentifier
        );
        $data = $this->AirArabiaApi($data);
        return $data;
    }

    public function AirAribiaBooking($airPricingSolution , $travelersdata , $flightbookingdetails , $traceId)
    {
        $countryDetails = Country::find($flightbookingdetails->country_id);
        $phoneNumber = $flightbookingdetails->mobile;
        $email = $flightbookingdetails->email;
        $countryphoneCode = substr($countryDetails->phone_code,1);
        $countryCode = $countryDetails->country_code;
        $transactionIdentifier = $airPricingSolution['transactionIdentifier'];

        //Xml Prepration
        $xml = <<<EOM
        <soap:Envelope xmlns:soap="$this->soapenvelope" xmlns:xsd="$this->w3Org" xmlns:xsi="$this->w3Org-instance">
        <soap:Header>
            <wsse:Security soap:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken wsu:Id="UsernameToken-17855236" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <wsse:Username>$this->AirArabiaUsername</wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">$this->AirArabiaPassword</wsse:Password>
            </wsse:UsernameToken>
            </wsse:Security>
        </soap:Header>
        EOM;

        $curentTimeStamp = Carbon::now()->format('Y-m-d')."T".Carbon::now()->format('H:i:s');

        $xml .=<<<EOM
        <soap:Body xmlns:ns1="http://www.isaaviation.com/thinair/webservices/OTA/Extensions/2003/05" xmlns:ns2="http://www.opentravel.org/OTA/2003/05">
            <ns2:OTA_AirBookRQ EchoToken="11868765275150-1300257933" PrimaryLangID="en-us" SequenceNmbr="1" TimeStamp="$curentTimeStamp" TransactionIdentifier="$transactionIdentifier" Version="20061.00">
            <ns2:POS>
                <ns2:Source TerminalID="TestUser/Test Runner">
                <ns2:RequestorID ID="$this->AirArabiaUsername" Type="4" />
                <ns2:BookingChannel Type="12" />
                </ns2:Source>
            </ns2:POS>
            <ns2:AirItinerary>
                <ns2:OriginDestinationOptions>
              
        EOM;
        foreach ($airPricingSolution['airSegments'] as $itkey => $itvalue) {
            if(isset($itvalue['from']) && $itvalue['from'] == 'mobile')
            {
                $itvalue['airarabiaData'] =json_decode($itvalue['airarabiaData'],true);
            }
            $FlightSegment = $this->arrayValues($itvalue['airarabiaData']['ns1:FlightSegment']['@attributes'] , '');
            $DepartureAirport = $this->arrayValues($itvalue['airarabiaData']['ns1:FlightSegment']['ns1:DepartureAirport']['@attributes'] , '');
            $ArrivalAirport = $this->arrayValues($itvalue['airarabiaData']['ns1:FlightSegment']['ns1:ArrivalAirport']['@attributes'] , '');
            
            $xml .=<<<EOM
                            <ns2:OriginDestinationOption>
                                <ns2:FlightSegment  $FlightSegment >
                                    <ns2:DepartureAirport $DepartureAirport />
                                    <ns2:ArrivalAirport $ArrivalAirport />
                                </ns2:FlightSegment>
                            </ns2:OriginDestinationOption>
                    EOM; 
            }
            $xml .=<<<EOM
                </ns2:OriginDestinationOptions>
            </ns2:AirItinerary>
            <ns2:TravelerInfo>
            EOM; 

            foreach($travelersdata as $index => $travelersdetails)
            {
                $travelerType = $travelersdetails->traveler_type;
                $travelerType = ($travelerType == 'CNN' ) ? 'CHD' : $travelerType;
                
                $title = Str::upper($travelersdetails->title);
                $firstName = $travelersdetails->first_name;
                $lastName = $travelersdetails->last_name;
                $dob = Carbon::create($travelersdetails->date_of_birth)->isoFormat('YYYY-MM-DD')."T00:00:00";
                $passportIssuedCountryCode = $travelersdetails->passportIssuedCountry->country_code ?? '';
                $travelerRefId = $travelersdetails->traveler_ref_id;
                // if($travelerType == "ADT")
                // {
                //     $travelerRefId = 'A'.$index+1;
                // }else{
                //     $travelerRefId = 'A'.$index+1;
                // }
                $xml .=<<<EOM
                <ns2:AirTraveler BirthDate="$dob" PassengerTypeCode="$travelerType">
                <ns2:PersonName>
                    <ns2:GivenName>$firstName</ns2:GivenName>
                    <ns2:Surname>$lastName</ns2:Surname>
                    <ns2:NameTitle>$title</ns2:NameTitle>
                </ns2:PersonName>
                EOM;
                if($travelerType != 'INF')
                {
                    $xml .=<<<EOM
                    <ns2:Telephone  CountryAccessCode="$countryphoneCode" PhoneNumber="$phoneNumber" />
                    <ns2:Address>
                        <ns2:CountryName Code="$countryCode" />
                    </ns2:Address>
                    <ns2:Document DocHolderNationality="$passportIssuedCountryCode" />
                    EOM;
                 }
                // else
                // {
                    
                //     $xml .=<<<EOM
                
                //     <ns2:TravelerRefNumber RPH="$travelerRefId" />
                // <ns2:TravelerRefNumber RPH="I3/A1" />

                //     </ns2:AirTraveler>
                //     EOM;
                // }

                $xml .=<<<EOM
                <ns2:TravelerRefNumber RPH="$travelerRefId" />
                </ns2:AirTraveler>
                EOM;

            }

            $payAmount = $this->arrayValues($airPricingSolution['pricing']['@attributes'] , '');
            $title = Str::upper($travelersdata[0]->title);
            $first_name = ($travelersdata[0]->first_name);
            $last_name = ($travelersdata[0]->last_name);
            $bsp = '';
            if(env('APP_ENV') == 'prod')
            {
                $bsp = 'CodeContext="BSP"';
            }
            
    $xml .=<<<EOM
            </ns2:TravelerInfo>
            <ns2:Fulfillment>
                <ns2:PaymentDetails>
                <ns2:PaymentDetail>
                    <ns2:DirectBill>
                    <ns2:CompanyName Code="$this->AirarabiaCompanyCode" $bsp/>
                    </ns2:DirectBill>
                    <ns2:PaymentAmount $payAmount />
                </ns2:PaymentDetail>
                </ns2:PaymentDetails>
            </ns2:Fulfillment>
            </ns2:OTA_AirBookRQ>
            <ns1:AAAirBookRQExt>
            <ns1:ContactInfo>
              <ns1:PersonName>
                <ns1:Title>$title</ns1:Title>
                <ns1:FirstName>$first_name</ns1:FirstName>
                <ns1:LastName>$last_name</ns1:LastName>
              </ns1:PersonName>
              <ns1:Telephone>
                <ns1:PhoneNumber>$phoneNumber</ns1:PhoneNumber>
                <ns1:CountryCode>$countryphoneCode</ns1:CountryCode>
              </ns1:Telephone>
              <ns1:Email>$email</ns1:Email>
              <ns1:Address>
                <ns1:CountryName>
                  <ns1:CountryName>$countryDetails->name</ns1:CountryName>
                  <ns1:CountryCode>$countryCode</ns1:CountryCode>
                </ns1:CountryName>
              </ns1:Address>
            </ns1:ContactInfo>
          </ns1:AAAirBookRQExt>
        </soap:Body>
      </soap:Envelope>
    EOM;
    $data = array(
        'xml' => $xml,
        'trace_id' => $traceId,
        'request_type' => 'ticketing',
        'transactionIdentifier' => $transactionIdentifier
    );
    $data = $this->AirArabiaApi($data);
    return $data;
    }

    public function getTravelportUniversalRecord($input){
        $universalPnr= $input['universalPnr'];
        $traceId = $input['traceId'];
        $xml = <<<EOM
        <soapenv:Envelope xmlns:soapenv="$this->soapenvelope">
        <soapenv:Header/><soapenv:Body>
            <UniversalRecordRetrieveReq xmlns="$this->universalXmlns" TraceId="$traceId" AuthorizedBy="Travelport" TargetBranch="$this->TragetBranch">
                <BillingPointOfSaleInfo xmlns="$this->commonXmlns" OriginApplication="uAPI" />
                <UniversalRecordLocatorCode>$universalPnr</UniversalRecordLocatorCode>
            </UniversalRecordRetrieveReq>
        </soapenv:Body>
        </soapenv:Envelope>
        EOM;



        $controllerdata = array(
        'xml' => $xml,
        'trace_id' => $traceId,
        'request_type' => 'universalRecordRetrieve'
        );
        $data = $this->TravelportAirApi($controllerdata);
        return $data;
    } 

    public function bookingQuoteRequestJazeera($flightDetails,$UserRequest,$traceId){

        $requestFrom = "WEB";
        if(isset($UserRequest['requestFrom'])){
            $requestFrom = $UserRequest['requestFrom'];
        }
        
        $noOfAdults   = $UserRequest['noofAdults'] ? (int) $UserRequest['noofAdults'] : 0;
        $noOfChildren = $UserRequest['noofChildren'] ? (int) $UserRequest['noofChildren'] : 0;
        $noOfInfants  = $UserRequest['noofInfants'] ? (int) $UserRequest['noofInfants'] : 0;
        $currencyCode = isset($UserRequest['currencyCode']) ? $UserRequest['currencyCode'] : 'KWD'; 
        $tokenData    = isset($UserRequest['tokenData']) ? $UserRequest['tokenData'] : null;

        $keyDetails   = [];
        if($UserRequest['flight-trip'] ==="onewaytrip"){
            $keydetails = [
                ["journeyKey"          => $flightDetails['journeyKey'],
                "fareAvailabilityKey" => $flightDetails['fareAvailabilityKey'],
                "standbyPriorityCode" => null,
                "inventoryControl"    => null,],
            ];
        }else{
            $keydetails = [
                [
                    "journeyKey"          => $flightDetails['outBoundJourneyKey'],
                    "fareAvailabilityKey" => $flightDetails['outBoundFareKey'],
                    "standbyPriorityCode" => null,
                    "inventoryControl"    => null,
                ],
                [
                    "journeyKey"          => $flightDetails['inBoundJourneyKey'],
                    "fareAvailabilityKey" => $flightDetails['inBoundFareKey'],
                    "standbyPriorityCode" => null,
                    "inventoryControl"    => null,
                ],
            ];
        }
        
        $passengerTypes = [];

        // Add adult passenger type
        if ($noOfAdults !== null && $noOfAdults > 0) {
            $passengerTypes[] = [
                "type" => "ADT",
                "count" => $noOfAdults
            ];
        }

        // Add child passenger type
        if ($noOfChildren !== null && $noOfChildren > 0) {
            $passengerTypes[] = [
                "type" => "CHD",
                "count" => $noOfChildren
            ];
        } 

        $body = [
            "keys" => $keydetails,
            "passengers" => [
                "types" => $passengerTypes,
                "residentCountry" => ""
            ],
            "currencyCode" => $currencyCode,
            "infantCount" => $noOfInfants,
            "promotionCode" => "",
            "sourceOrganization" => ""
        ];

        $trace_id  = TravelportRequest::count() + 1;
        $data = array(
            'jsonRequest'   => $body,
            'trace_id'      => $trace_id,
            'endpoint'      => 'BookingQuote',
            'request_type'  => 'BookingQuote',
            'requestFrom'   => $requestFrom,
            'tokenData'     => $tokenData,
        );
        $data = $this->postMethodForJazeera($data);
        //dd($data);
        return $data;
    }

    public function tripSellRequestJazeera($flightDetails,$UserRequest,$traceId,$extraInfo){
        $requestFrom = "WEB";
        if(isset($UserRequest['requestFrom'])){
            $requestFrom = $UserRequest['requestFrom'];
        }

        $noOfAdults   = $UserRequest['noofAdults'] ? (int) $UserRequest['noofAdults'] : 0;
        $noOfChildren = $UserRequest['noofChildren'] ? (int) $UserRequest['noofChildren'] : 0;
        $noOfInfants  = $UserRequest['noofInfants'] ? (int) $UserRequest['noofInfants'] : 0;
        $currencyCode = isset($UserRequest['currencyCode']) ? $UserRequest['currencyCode'] : 'KWD'; 
        $tokenData    = isset($UserRequest['tokenData']) ? $UserRequest['tokenData'] : null;

        $keyDetails   = [];
        if($UserRequest['flight-trip'] ==="onewaytrip"){
            $keydetails = [
                ["journeyKey"          => $flightDetails['journeyKey'],
                "fareAvailabilityKey" => $flightDetails['fareAvailabilityKey'],
                "standbyPriorityCode" => null,
                "inventoryControl"    => null,],
            ];
        }else{
            $keydetails = [
                [
                    "journeyKey"          => $flightDetails['outBoundJourneyKey'],
                    "fareAvailabilityKey" => $flightDetails['outBoundFareKey'],
                    "standbyPriorityCode" => null,
                    "inventoryControl"    => null,
                ],
                [
                    "journeyKey"          => $flightDetails['inBoundJourneyKey'],
                    "fareAvailabilityKey" => $flightDetails['inBoundFareKey'],
                    "standbyPriorityCode" => null,
                    "inventoryControl"    => null,
                ],
            ];
        }
        
        $passengerTypes = [];
        
        // Add adult passenger type
        if ($noOfAdults !== null && $noOfAdults > 0) {
            $passengerTypes[] = [
                "type" => "ADT",
                "count" => $noOfAdults
            ];
        }

        // Add child passenger type
        if ($noOfChildren !== null && $noOfChildren > 0) {
            $passengerTypes[] = [
                "type" => "CHD",
                "count" => $noOfChildren
            ];
        } 
        
        $tripSellBodyRequest = [
            "keys" => $keydetails,
            "passengers" => [
                "types" => $passengerTypes,
                "residentCountry" => ""
            ],
            "currencyCode" => $currencyCode,
            "infantCount" => $noOfInfants,
            "promotionCode" => "",
            "sourceOrganization" => ""
        ];

        // $traceIdTripSell  = TravelportRequest::count() + 1;
        $lastTravelportRequest = TravelportRequest::latest()->first();
        $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();
        $traceIdTripSell  = $lastId + 1;
        $tripSellRequest = array(
            'jsonRequest'   => $tripSellBodyRequest,
            'trace_id'      => $traceIdTripSell,
            'endpoint'      => 'TripSell',
            'request_type'  => 'TripSell',
            'requestFrom'   => $requestFrom,
            'tokenData'     => $tokenData,
        );

        $tripSellResponseAll    = $this->postMethodForJazeera($tripSellRequest);
        $tripSellResponse       = $tripSellResponseAll['jazeeraResponse'];


        if (isset($tripSellResponse['Booking']['bookingReset']) && $tripSellResponse['Booking']['bookingReset'] === true ) {
            if(isset($extraInfo['passengers']) && isset($extraInfo['travelersInfo'])){
                $passangerBodyRequest = $this->prepareBodyRequestToAddPassangers($extraInfo);
            }
        }else{

            $data['jazeeraResponse'][0]['dotrezAPI']['dotrezErrors']['errors'][0]['rawMessage'] = isset($tripSellResponse['errors'][0]['rawMessage']) ? $tripSellResponse['errors'][0]['rawMessage'] : "Something went wrong";
            return $data;
        }

        /*Token Data*/
        if(isset($tripSellResponseAll['tokenData'])){
            $newTokenData = $tripSellResponseAll['tokenData'];
        }

        $lastTravelportRequest = TravelportRequest::latest()->first();
        $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();

        $traceIdPassangers  = $lastId + 1;
        $traceIdBookingQuote  = $lastId + 2;
        
        
        // $traceIdPassangers     = TravelportRequest::count() + 1;
        // $traceIdBookingQuote   = TravelportRequest::count() + 2;
        $data = [
            "types"             => "parallel",
            
           
            [
                'jsonRequest'   => $passangerBodyRequest,
                'trace_id'      => $traceIdPassangers,
                'endpoint'      => 'Passengers',
                'request_type'  => 'AddPassengers',
            ],
            [
                'jsonRequest'   => $tripSellBodyRequest,
                'trace_id'      => $traceIdBookingQuote,
                'endpoint'      => 'BookingQuote',
                'request_type'  => 'BookingQuote',
            ],

            'requestFrom'       => $requestFrom,
            'tokenData'         => $newTokenData,

        ];
         
        $returnData             = $this->postMethodForJazeera($data);
        $passangerAddResponse   = $returnData[0]['jazeeraResponse'];
        $bookingQuoteResponse   = $returnData[1]['jazeeraResponse'];

        
        if (isset($passangerAddResponse['success']) && $passangerAddResponse['addPassengerResponse'][0]['success'] === true) {
            if ($requestFrom === "MOBILE") {
                $AirPricingInfo['trace_id'] = $returnData[1]['trace_id'];
                $AirPricingInfo['jazeeraResponse'] = $bookingQuoteResponse;    
                $AirPricingInfo['tokenData'] = $returnData[1]['tokenData'];
            }else{
                $AirPricingInfo['trace_id'] = $returnData[1]['trace_id']; 
                $AirPricingInfo['jazeeraResponse'] = $bookingQuoteResponse;    
            }
            
        }else{
            $AirPricingInfo['jazeeraResponse'][0]['dotrezAPI']['dotrezErrors']['errors'][0]['rawMessage'] = "Something went wrong.";
        }

        return $AirPricingInfo;
    }

    public function tripSellRequestJazeeraBackUp($flightDetails,$UserRequest,$traceId,$extraInfo){
        $noOfAdults   = $UserRequest['noofAdults'] ? (int) $UserRequest['noofAdults'] : 0;
        $noOfChildren = $UserRequest['noofChildren'] ? (int) $UserRequest['noofChildren'] : 0;
        $noOfInfants  = $UserRequest['noofInfants'] ? (int) $UserRequest['noofInfants'] : 0;
        $keyDetails   = [];
        if($UserRequest['flight-trip'] ==="onewaytrip"){
            $keydetails = [
                ["journeyKey"          => $flightDetails['journeyKey'],
                "fareAvailabilityKey" => $flightDetails['fareAvailabilityKey'],
                "standbyPriorityCode" => null,
                "inventoryControl"    => null,],
            ];
        }else{
            $keydetails = [
                [
                    "journeyKey"          => $flightDetails['outBoundJourneyKey'],
                    "fareAvailabilityKey" => $flightDetails['outBoundFareKey'],
                    "standbyPriorityCode" => null,
                    "inventoryControl"    => null,
                ],
                [
                    "journeyKey"          => $flightDetails['inBoundJourneyKey'],
                    "fareAvailabilityKey" => $flightDetails['inBoundFareKey'],
                    "standbyPriorityCode" => null,
                    "inventoryControl"    => null,
                ],
            ];
        }
        
        $passengerTypes = [];
        
        // Add adult passenger type
        if ($noOfAdults !== null && $noOfAdults > 0) {
            $passengerTypes[] = [
                "type" => "ADT",
                "count" => $noOfAdults
            ];
        }

        // Add child passenger type
        if ($noOfChildren !== null && $noOfChildren > 0) {
            $passengerTypes[] = [
                "type" => "CHD",
                "count" => $noOfChildren
            ];
        } 
        
        $tripSellBodyRequest = [
            "keys" => $keydetails,
            "passengers" => [
                "types" => $passengerTypes,
                "residentCountry" => ""
            ],
            "currencyCode" => "KWD",
            "infantCount" => $noOfInfants,
            "promotionCode" => "",
            "sourceOrganization" => ""
        ];
        
        $passangerBodyRequest = null;
        if(isset($extraInfo['passengers']) && isset($extraInfo['travelersInfo'])){
            $passangerBodyRequest = $this->prepareBodyRequestToAddPassangers($extraInfo);
        }

        $lastTravelportRequest = TravelportRequest::latest()->first();
        $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();

        $traceIdTripSell  = $lastId + 1;
        $traceIdPassangers  = $lastId + 2;
        $traceIdBookingQuote = $lastId + 3;

        // $traceIdTripSell       = TravelportRequest::count() + 1;
        // $traceIdPassangers     = TravelportRequest::count() + 2;
        // $traceIdBookingQuote   = TravelportRequest::count() + 3;

        $data = [
            "types"             => "parallel",
            [
                'jsonRequest'   => $tripSellBodyRequest,
                'trace_id'      => $traceIdTripSell,
                'endpoint'      => 'TripSell',
                'request_type'  => 'airPricing',
            ],
            [
                'jsonRequest'   => $passangerBodyRequest,
                'trace_id'      => $traceIdPassangers,
                'endpoint'      => 'Passengers',
                'request_type'  => 'airPricing',
            ],
            [
                'jsonRequest'   => $tripSellBodyRequest,
                'trace_id'      => $traceIdBookingQuote,
                'endpoint'      => 'BookingQuote',
                'request_type'  => 'airPricing',
            ],
        ];

        $returnData             = $this->postMethodForJazeera($data);
        $tripSellResponse       = $returnData[0]['jazeeraResponse'];
        $passangerAddResponse   = $returnData[1]['jazeeraResponse'];
        $bookingQuoteResponse   = $returnData[2]['jazeeraResponse'];

        /*echo "test";echo "<pre>";print_r($tripSellResponse);
        echo "test";echo "<pre>";print_r($passangerAddResponse);
        echo "test";echo "<pre>";print_r($bookingQuoteResponse);
        dd("BC-1307");*/
        // && isset($passangerAddResponse['success']) && $passangerAddResponse['addPassengerResponse'][0]['success'] === true
        if (isset($tripSellResponse['Booking']['bookingReset']) && $tripSellResponse['Booking']['bookingReset'] === true && isset($passangerAddResponse['success']) && $passangerAddResponse['addPassengerResponse'][0]['success'] === true) {
            $AirPricingInfo['jazeeraResponse'] = $bookingQuoteResponse;
        }else{
            $AirPricingInfo['jazeeraResponse'][0]['dotrezAPI']['dotrezErrors']['errors'][0]['rawMessage'] = "Something went wrong.";
        }

        return $AirPricingInfo;
    }


    public function prepareBodyRequestToAddPassangers($details)
    {
        
        if(!empty($details)){
            // Get passenger information from $details['passengers']
            $jsonBody = [
                "passengers" => [],
                "contact" => [
                    "contactTypeCode" => "P",
                    "phoneNumbers" => [
                        [
                            "type"    => "Other",
                            "number"  => "+965-60745502",
                        ]
                    ],
                    "cultureCode" => "en-GB",
                    "address" => [
                        "lineOne"      => "Sharq",
                        "lineTwo"      => "Kuwait",
                        "lineThree"    => "Kuwait",
                        "countryCode"  => "KW",
                        "provinceState"=> "",
                        "city"         => "Kuwait",
                        "postalCode"   => ""
                    ],
                    "emailAddress"       => "amr@masilagroup.com",
                    "distributionOption" => "Email",
                    "customerNumber"     => "",
                    "sourceOrganization" => $this->jazeeraOrganizationNumber,
                    "companyName"        => "Al-Masila Group Int’l Tourism & Travel Co.",
                    "name" => [
                        "first"     => "Amr",
                        "middle"    => "",
                        "last"      => "Fathalla",
                        "title"     => "MR",
                        "suffix"    => ""
                    ]
                ]
            ];

            $adultPassengerDataList = [];
            $usedPassengerKeys = [];
            $passengersKeyFromJazeera = $details['passengers'];
            $jsonBody["passengers"] = [];
            
            // Initialize an array to keep track of used passenger keys
            if(isset($details['requestTFrom']) && $details['requestTFrom'] =="MOBILE"){
               
                $travelersInfo = $details['travelersInfo'];
                foreach ($travelersInfo as $traveler) { 
                    if($traveler['passengerType'] == "ADT"){
                        $passengerTypeCode  = "ADT";
                        $country            = Country::find($traveler['passportIssueCountry']);
                        $adultCountry       = isset($country) ? $country->country_code :null;
                        // Find the passenger key based on the passenger type code
                        $passengerKey = null;
                        foreach ($passengersKeyFromJazeera as $passenger) {    
                            if ($passenger['passengerTypeCode'] === $passengerTypeCode && !in_array($passenger['passengerKey'], $usedPassengerKeys)) {
                                $passengerKey           = $passenger['passengerKey'];
                                $usedPassengerKeys[]    = $passengerKey; // Add the used key to the array
                                break;
                            }
                        }

                          // Proceed if a passenger key is found
                        if ($passengerKey) {
                            $gender = $traveler['title'] === 'Mr' ? 'Male' : 'Female';
                            // Create the passenger object for each adult or child
                            $adultPassengerData = [
                                "passengerKey"  => $passengerKey,
                                "passengerInfo" => [
                                    "customerNumber" => "",
                                    "name" => [
                                        "first"     => $traveler['firstName'],
                                        "middle"    => "",
                                        "last"      => $traveler['lastName'],
                                        "title"     => $traveler['title'],
                                        "suffix"    => ""
                                    ],
                                    "discountCode" => "",
                                    "info" => [
                                        "nationality"       => $adultCountry,
                                        "residentCountry"   => $adultCountry,
                                        "gender"            => $gender,
                                        "dateOfBirth"       => $traveler['dob'],
                                        "familyNumber"      => 0
                                    ]
                                ],
                                "infant" =>  null,
                            ];
 
                            // Add the passenger data to the list for infant association
                             $adultPassengerDataList[] = $adultPassengerData;
                        }
                    }elseif($traveler['passengerType'] == "CNN"){
                        $passengerTypeCode  = "CHD";
                        $country            = Country::find($traveler['passportIssueCountry']);
                        $childCountry       = isset($country) ? $country->country_code :null;
                        // Find the passenger key based on the passenger type code
                        $passengerKey = null;
                        foreach ($passengersKeyFromJazeera as $passenger) {    
                            if ($passenger['passengerTypeCode'] === $passengerTypeCode && !in_array($passenger['passengerKey'], $usedPassengerKeys)) {
                                $passengerKey           = $passenger['passengerKey'];
                                $usedPassengerKeys[]    = $passengerKey; // Add the used key to the array
                                break;
                            }
                        }

                         // Proceed if a passenger key is found
                        if ($passengerKey) {
                            $gender    = $traveler['title'] === 'Master' ? 'Male' : 'Female';
                            $titles    = $gender === 'Male' ? 'Mr' : 'Miss';
                            $passenger = [
                                "passengerKey"  => $passengerKey,
                                "passengerInfo" => [
                                    "customerNumber" => "",
                                    "name" => [
                                        "first"     => $traveler['firstName'],
                                        "middle"    => "",
                                        "last"      => $traveler['lastName'],
                                        "title"     => $traveler['title'],
                                        "suffix"    => ""
                                    ],
                                    "discountCode" => "",
                                    "info" => [
                                        "nationality"       => $childCountry,
                                        "residentCountry"   => $childCountry,
                                        "gender"            => $gender,
                                        "dateOfBirth"       => $traveler['dob'],
                                        "familyNumber"      => 0
                                    ]
                                ],
                            ];
                            $jsonBody["passengers"][] = $passenger;
                        }
                    }
                }

                // Process infants and associate them with adults
                foreach ($travelersInfo as $traveler) {
                    if ($traveler['passengerType'] == "INF") {
                        $passengerTypeCode  = "INF";
                        $gender             = $traveler['title'] === 'Master' ? 'Male' : 'Female';
                        $title              = $gender === 'Male' ? 'Mr' : 'Miss';
                        $country            =  Country::find($traveler['passportIssueCountry']);
                        $infCountry         =  isset($country) ? $country->country_code :null;
                        // Find an available adult passenger data for infant association
                        if (!empty($adultPassengerDataList)) {
                            $adultPassengerData = array_shift($adultPassengerDataList);

                            // Construct infant details
                                $infant = [
                                    "nationality"       => $infCountry,
                                    "residentCountry"   => $infCountry,
                                    "dateOfBirth"       => $traveler['dob'],
                                    "gender"            => $gender, // Set the gender as needed
                                    "name" => [
                                        "first"     => $traveler['firstName'],
                                        "middle"    => "",
                                        "last"      => $traveler['lastName'],
                                        "title"     => $title,
                                        "suffix"    => ""
                                    ]
                                ];

                            // Associate the infant with the adult passenger
                            $adultPassengerData["infant"] = $infant;

                            // Add the updated adult passenger data (with infant) to the "passengers" array
                            $jsonBody["passengers"][] = $adultPassengerData;
                        }
                    }
                }
                $jsonBody["passengers"] = array_merge($jsonBody["passengers"], $adultPassengerDataList);

            }else{
                $travelersInfo = $details['travelersInfo']->toArray();    
                if(isset($travelersInfo['adultTitle'])){
                    foreach ($travelersInfo['adultTitle'] as $i => $adultTitle) {
                        // Determine the passenger type code based on the adult or child title

                        $passengerTypeCode = "ADT";
                        $country        = Country::find($travelersInfo['adultPassportIssueCountry'][$i]);
                        $adultCountry   = isset($country) ? $country->country_code :null;
                            

                        // Find the passenger key based on the passenger type code
                        $passengerKey = null;
                        foreach ($passengersKeyFromJazeera as $passenger) {
                            if ($passenger['passengerTypeCode'] === $passengerTypeCode && !in_array($passenger['passengerKey'], $usedPassengerKeys)) {
                                $passengerKey           = $passenger['passengerKey'];
                                $usedPassengerKeys[]    = $passengerKey; // Add the used key to the array
                                break;
                            }
                        }

                        // Proceed if a passenger key is found
                        if ($passengerKey) {
                            $gender = $adultTitle === 'Mr' ? 'Male' : 'Female';
                            // Create the passenger object for each adult or child
                            $passenger = [
                                "passengerKey"  => $passengerKey,
                                "passengerInfo" => [
                                    "customerNumber" => "",
                                    "name" => [
                                        "first"     => $travelersInfo['adultFirstName'][$i],
                                        "middle"    => "",
                                        "last"      => $travelersInfo['adultLastName'][$i],
                                        "title"     => $adultTitle,
                                        "suffix"    => ""
                                    ],
                                    "discountCode" => "",
                                    "info" => [
                                        "nationality"       => $adultCountry,
                                        "residentCountry"   => $adultCountry,
                                        "gender"            => $gender,
                                        "dateOfBirth"       => $travelersInfo['adultDOB'][$i],
                                        "familyNumber"      => 0
                                    ]
                                ],
                                "infant" =>  null,
                            ];

                            // Check if there is an infant for the current passenger
                            if (isset($travelersInfo['infantsTitle'][$i])) {
                                $gender     = $travelersInfo['infantsTitle'][$i] === 'Master' ? 'Male' : 'Female';
                                $title     = $gender === 'Male' ? 'Mr' : 'Miss';
                                $country    = Country::find($travelersInfo['infantsPassportIssueCountry'][$i]);
                                $infCountry = isset($country) ? $country->country_code :null;
                                // Create the infant object
                                $infant = [
                                    "nationality"       => $infCountry,
                                    "residentCountry"   => $infCountry,
                                    "dateOfBirth"       => $travelersInfo['infantsDOB'][$i],
                                    "gender"            => $gender, // Set the gender as needed
                                    "name" => [
                                        "first"     => $travelersInfo['infantsFirstName'][$i],
                                        "middle"    => "",
                                        "last"      => $travelersInfo['infantsLastName'][$i],
                                        "title"     => $title,
                                        "suffix"    => ""
                                    ]
                                ];

                                // Assign the infant object to the passenger
                                $passenger['infant'] = $infant;
                            }
                            // Add the passenger to the "passengers" array
                            $jsonBody["passengers"][] = $passenger;
                        }
                    }
                }
                if(isset($travelersInfo['childrenTitle'])){
                    foreach ($travelersInfo['childrenTitle'] as $i => $childTitle) {
                        $passengerTypeCode  = "CHD";
                        $country            = Country::find($travelersInfo['childrenPassportIssueCountry'][$i]);
                        $childCountry       = isset($country) ? $country->country_code : null;

                        // Find the passenger key based on the passenger type code
                        $passengerKey = null;
                        foreach ($passengersKeyFromJazeera as $passenger) {
                            if ($passenger['passengerTypeCode'] === $passengerTypeCode && !in_array($passenger['passengerKey'], $usedPassengerKeys)) {
                                $passengerKey = $passenger['passengerKey'];
                                $usedPassengerKeys[] = $passengerKey; // Add the used key to the array
                                break;
                            }
                        }

                        // Proceed if a passenger key is found
                        if ($passengerKey) {
                            $gender    = $travelersInfo['childrenTitle'][$i] === 'Master' ? 'Male' : 'Female';
                            $titles    = $gender === 'Male' ? 'Mr' : 'Miss';
                            $passenger = [
                                "passengerKey"  => $passengerKey,
                                "passengerInfo" => [
                                    "customerNumber" => "",
                                    "name" => [
                                        "first"     => $travelersInfo['childrenFirstName'][$i],
                                        "middle"    => "",
                                        "last"      => $travelersInfo['childrenLastName'][$i],
                                        "title"     => $titles,
                                        "suffix"    => ""
                                    ],
                                    "discountCode" => "",
                                    "info" => [
                                        "nationality"       => $childCountry,
                                        "residentCountry"   => $childCountry,
                                        "gender"            => $gender,
                                        "dateOfBirth"       => $travelersInfo['childrenDOB'][$i],
                                        "familyNumber"      => 0
                                    ]
                                ],
                            ];
                            $jsonBody["passengers"][] = $passenger;
                        }
                    }
                }
            }
            
            return $jsonBody;
        }
    }

    public function airJazeeraBookingCommit($airPricingSolution , $travelersdata , $flightbookingdetails , $traceId){
 
        $tokenData    = isset($airPricingSolution['tokenData']) ? $airPricingSolution['tokenData'] : null;
        $requestFrom = isset($airPricingSolution['requestFrom']) && $airPricingSolution['requestFrom'] === "MOBILE" ? $airPricingSolution['requestFrom'] : 'WEB';


        $createdDate     = Carbon::now()->toDateTimeString();
       /* echo "<pre>";echo"airPricingSolution"; print_r($airPricingSolution);
        echo "<pre>";echo"travelersdata"; print_r($travelersdata);
        echo "<pre>";echo"flightbookingdetails"; print_r($flightbookingdetails);
        echo "<pre>";echo"traceId"; echo($traceId);*/
        if(isset($airPricingSolution['requestFrom']) && $airPricingSolution['requestFrom']==="MOBILE"){
            $requestFrom =  $airPricingSolution['requestFrom'];
        }

        /*Commit booking to get PNR*/
        $commitBooking = [
            "receivedBy" => "OTA",
            "restrictionOverride" => true,
            "notifyContacts" => true,
            "comments" => [
                [
                    "type" => "Default",
                    "text" => "Al-Masila Group Int’l Tourism & Travel Co - REFBOOKINGID#" . $flightbookingdetails->id,
                    "createdDate" => ""
                ]
            ]
        ];

        

        // $trace_id  = TravelportRequest::count() + 1;

        $lastTravelportRequest = TravelportRequest::latest()->first();
        $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();
        $trace_id  = $lastId + 1;
        
        $data = array(
            'jsonRequest'   => $commitBooking,
            'trace_id'      => $trace_id,
            'endpoint'      => 'Booking/CommitBooking',
            'request_type'  => 'CommitBooking',
            'requestFrom'   => $requestFrom,
            'tokenData'     => $tokenData,
        );


        $returnData         = $this->postMethodForJazeera($data);
        $bookingCommitData  = $returnData['jazeeraResponse'];

        /*END Commit booking*/

        //AGAIN CHECK GET BOOKING API TO GET STATUS AS PER JAZEERA TEAM
        $getBookingRequestStatus = [
            'BookingDetailsType'  => 'BalanceDue',
        ];
        $endpointBookingRequestStatus = 'BookingDetails';
        $extraInfo = null;
        if($requestFrom==="MOBILE"){
            $extraInfo = [
                'tokenData' => $returnData['tokenData'],
                'requestFrom' => $requestFrom
            ]; 
        }
        $bookingDetailsStatus         = $this->getMethodForJazeera($getBookingRequestStatus,$endpointBookingRequestStatus,$extraInfo);
        if(isset($bookingDetailsStatus['jazeeraResponse']['data']['booking']['info'])){
            $status =  $bookingDetailsStatus['jazeeraResponse']['data']['booking']['info']['status'];
        }
        /*END*/


        if (isset($bookingCommitData['bookingCommitv3']) && !is_null($bookingCommitData['bookingCommitv3']['recordLocator']) && isset($status) && $status==="Hold") {
            //payment for jazeera

            $lastTravelportRequest = TravelportRequest::latest()->first();
            $lastId = ($lastTravelportRequest->id != null) ? $lastTravelportRequest->id : TravelportRequest::count();
            $payTraceID  = $lastId + 1;
            //$payTraceID  = TravelportRequest::count() + 1;
            $paymentBooking = [
                "serviceType"   => "Dotrez",
                "paymentType"   => "BSPCASH",
                "accountNumber" => "",
            ];
            $paymentBookingBody = array(
                'jsonRequest'   => $paymentBooking,
                'trace_id'      => $payTraceID,
                'endpoint'      => 'bspcash/pay',
                'request_type'  => 'bspcash/pay',
                'requestFrom'   => $requestFrom,
                'tokenData'     => $tokenData,
            );
            $returnDataPay         = $this->postMethodForJazeera($paymentBookingBody);
        }
        
        $getBookingRequest = [
            'BookingDetailsType'  => 'Complete',
        ];
        $endpointBookingRequest = 'BookingDetails';
        $bookingDetails         = $this->getMethodForJazeera($getBookingRequest,$endpointBookingRequest,$extraInfo);
        $bookingDetails['jazeeraRequest'] = $data;     
        $this->deleteTokenForJazeera($extraInfo);
        return $bookingDetails;
    }

    public function retrieveBookingByRecordLocator($data){

        $extraInfo = null;
        if($data['requestFrom']==="MOBILE"){
            $extraInfo = [
                'tokenData' => null,
                'requestFrom' => $data['requestFrom'],
            ]; 
        }
        $getBookingRequestStatus = [
            'RecordLocator'  => $data['pnr'],
        ];
        $endpointBookingRequestStatus = 'booking/RetrieveBookingByRecordLocator';
        $booking = $this->getMethodForJazeera($getBookingRequestStatus,$endpointBookingRequestStatus,$extraInfo);
        
        if(isset($booking['token'])){
            $tokenDeleteData = [
                'tokenData'     =>  $booking['token'],
                'requestFrom'   =>  $data['requestFrom'],
            ]; 
            $this->deleteTokenForJazeera($tokenDeleteData);
        }else{
            $tokenDeleteData = null;
            $this->deleteTokenForJazeera($tokenDeleteData);
        }
        return $booking; 
    }
}
