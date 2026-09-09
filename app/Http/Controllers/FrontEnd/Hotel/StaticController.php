<?php

namespace App\Http\Controllers\FrontEnd\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Hotel\Xml\SearchController;
use App\Models\DidaCity;
use App\Models\DidaHotel;
use App\Models\DidaHotelList;
use App\Models\HotelCity;
use App\Models\TboHotel;
use App\Models\TboHotelsCity;
use App\Models\TboHotelsCode;
use App\Models\TboHotelsCountry;
use App\Models\WebbedsCity;
use App\Models\WebbedsCountry;
use App\Models\WebbedsHotel;
use App\Models\GtsHotel;
use App\Models\GtsHotelList;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Provincia;
use App\Models\RestelCity;
use App\Models\GtsCityHotel;

class StaticController extends Controller
{
    public function downloadTBOHoteldDetails(){
     

        $countryListUrl = env('TBO_HOTEL_URL') . "CountryList";
        $countries = $this->TBOApi($countryListUrl, 'get');
        if($countries['Status']['Code'] == 200)
        {
            //country list
            $countryList = $countries['CountryList'];
            foreach($countryList as $country)
            {
                $cityListUrl = env('TBO_HOTEL_URL') . "CityList";
                $postArray = array('CountryCode' => $country['Code']);
                $cities = $this->TBOApi($cityListUrl, 'post' , $postArray);
                if($cities['Status']['Code'] == 200)
                {
                    //cities list
                    $citiesList = $cities['CityList'];
                    foreach($citiesList as $city)
                    {
                        // echo "citiesList";
                        $hotelCodeUrl = env('TBO_HOTEL_URL') . "TBOHotelCodeList";
                        //$hotelCodeUrl url we will not get images 
                        $postArray = [];
                        $postArray = array('CityCode' => $country['Code'] , "IsDetailedResponse" => "false");
                        $hotelsCodes = $this->TBOApi($hotelCodeUrl, 'post' , $postArray);
                        if($hotelsCodes['Status']['Code'] == 200)
                        {
                            echo '<pre>';
                            $hotelsCodesList = $hotelsCodes['Hotels'];
                            print_r($hotelsCodesList);
                            //hotelsCodes list
                            $ChunkedhotelCodes = array_chunk(array_column($hotelsCodesList,'HotelCode'),50);
                            print_r($ChunkedhotelCodes);exit;
                            foreach($ChunkedhotelCodes as $indiviualChunkedCodes)
                            {
                                $hotelCodes = '';
                                $hotelCodes = implode(",",$indiviualChunkedCodes);
                                $hoteldetailsUrl = env('TBO_HOTEL_URL') . "Hoteldetails";
                                //$hoteldetailsUrl will get complte details about hotel
                                $postArray = [];
                                //we can send 50 hotel codes at once
                                $postArray = array( "Hotelcodes" => $hotelCodes,"Language"=> "en","IsDetailedResponse" => "true");
                                $hotels = $this->TBOApi($hoteldetailsUrl, 'post' , $postArray);
                                if($hotels['Status']['Code'] == 200)
                                {
                                    $hotelsList = $cities['HotelDetails'];
                                    foreach($hotelsList as $hotel)
                                    {
                                        if(!empty($hotel))
                                        {
                                            $hotalData = [];
                                            $hotalData = [
                                                'hotel_code' => $hotel['HotelCode'] ?? null,
                                                'hotel_name' => $hotel['HotelCode']?? null,
                                                'hotel_rating' => $hotel['HotelRating'] ?? null,
                                                'address' => $hotel['Address'] ?? null,
                                                'attractions' => $hotel['Attractions'] ?? null,
                                                'country_name' => $hotel['CountryName'] ?? null,
                                                'country_code' => $hotel['CountryCode'] ?? null,
                                                'description' => $hotel['Description'] ?? null,
                                                'fax_number' => $hotel['FaxNumber'] ?? null,
                                                'hotel_facilities' => isset($hotel['HotelFacilities']) ? implode(',',$hotel['HotelFacilities']) : NULL ,
                                                'map' => $hotel['Map'] ?? null,
                                                'phone_number' => $hotel['PhoneNumber'] ?? null,
                                                'pin_code' => $hotel['PinCode'] ?? null,
                                                'hotel_website_url' => $hotel['HotelWebsiteUrl'] ?? null,
                                                'city_name' => $hotel['CityName'] ?? null,
                                                'city_code' => $hotel['CityId'] ?? null,
                                                'images' => isset($hotel['Images']) ? implode(',',$hotel['Images']) : NULL ,
                                                'check_in' => $hotel['CheckInTime'] ?? null,
                                                'check_out' => $hotel['CheckOutTime'] ?? null,
                                            ];
                                            print_r($hotalData);
                                            exit;

                                            // DB::table('tbo_hotels')->where('email', $hotalData['hotel_code'])->updateOrInsert($hotalData);
                                        }
                                       
                                    }

                                }



                            }
                            

                        }
                    }
                    

                }

                // dd($cities);
            }
        }
        // foreach
        // dd( $countryList);
        

    }

    public function  dumpTBOCountrydump()
    {
        $countryListUrl = env('TBO_HOTEL_URL') . "CountryList";
        $countries = $this->TBOApi($countryListUrl, 'get');
        if($countries['Status']['Code'] == 200)
        {
            // dd($countries);
            //country list
            $countryList = $countries['CountryList'];
            $countryData = [];
            foreach($countryList as $country)
            {
                //$cityListUrl = env('TBO_HOTEL_URL') . "CityList";
                // dd($country);
                // $postArray = array('CountryCode' => $country['Code']);
                // $cities = $this->TBOApi($cityListUrl, 'post' , $postArray);
                // if($cities['Status']['Code'] == 200)
                // {
                //     //cities list
                //     $citiesList = $cities['CityList'];
                //     foreach($citiesList as $city)
                //     {
                //         // echo "citiesList";
                //         $hotelCodeUrl = env('TBO_HOTEL_URL') . "TBOHotelCodeList";
                //         //$hotelCodeUrl url we will not get images 
                //         $postArray = [];
                //         $postArray = array('CityCode' => $country['Code'] , "IsDetailedResponse" => "false");
                //         $hotelsCodes = $this->TBOApi($hotelCodeUrl, 'post' , $postArray);
                //         dd($hotelsCodes);
                //         if($hotelsCodes['Status']['Code'] == 200)
                //         {
                //             echo '<pre>';
                //             $hotelsCodesList = $hotelsCodes['Hotels'];
                //             print_r($hotelsCodesList);
                //             //hotelsCodes list
                //             $ChunkedhotelCodes = array_chunk(array_column($hotelsCodesList,'HotelCode'),50);
                //             print_r($ChunkedhotelCodes);exit;
                //             foreach($ChunkedhotelCodes as $indiviualChunkedCodes)
                //             {
                //                 $hotelCodes = '';
                //                 $hotelCodes = implode(",",$indiviualChunkedCodes);
                //                 $hoteldetailsUrl = env('TBO_HOTEL_URL') . "Hoteldetails";
                //                 //$hoteldetailsUrl will get complte details about hotel
                //                 $postArray = [];
                //                 //we can send 50 hotel codes at once
                //                 $postArray = array( "Hotelcodes" => $hotelCodes,"Language"=> "en","IsDetailedResponse" => "true");
                //                 $hotels = $this->TBOApi($hoteldetailsUrl, 'post' , $postArray);
                //                 if($hotels['Status']['Code'] == 200)
                //                 {
                //                     $hotelsList = $cities['HotelDetails'];
                //                     foreach($hotelsList as $hotel)
                //                     {
                //                         if(!empty($hotel))
                //                         {
                //                             $hotalData = [];
                //                             $hotalData = [
                //                                 'hotel_code' => $hotel['HotelCode'] ?? null,
                //                                 'hotel_name' => $hotel['HotelCode']?? null,
                //                                 'hotel_rating' => $hotel['HotelRating'] ?? null,
                //                                 'address' => $hotel['Address'] ?? null,
                //                                 'attractions' => $hotel['Attractions'] ?? null,
                //                                 'country_name' => $hotel['CountryName'] ?? null,
                //                                 'country_code' => $hotel['CountryCode'] ?? null,
                //                                 'description' => $hotel['Description'] ?? null,
                //                                 'fax_number' => $hotel['FaxNumber'] ?? null,
                //                                 'hotel_facilities' => isset($hotel['HotelFacilities']) ? implode(',',$hotel['HotelFacilities']) : NULL ,
                //                                 'map' => $hotel['Map'] ?? null,
                //                                 'phone_number' => $hotel['PhoneNumber'] ?? null,
                //                                 'pin_code' => $hotel['PinCode'] ?? null,
                //                                 'hotel_website_url' => $hotel['HotelWebsiteUrl'] ?? null,
                //                                 'city_name' => $hotel['CityName'] ?? null,
                //                                 'city_code' => $hotel['CityId'] ?? null,
                //                                 'images' => isset($hotel['Images']) ? implode(',',$hotel['Images']) : NULL ,
                //                                 'check_in' => $hotel['CheckInTime'] ?? null,
                //                                 'check_out' => $hotel['CheckOutTime'] ?? null,
                //                             ];
                //                             print_r($hotalData);
                //                             exit;

                //                             // DB::table('tbo_hotels')->where('email', $hotalData['hotel_code'])->updateOrInsert($hotalData);
                //                         }
                                       
                //                     }

                //                 }



                //             }
                            

                //         }
                //     }
                // }
                $countryData  = [
                    'code' => $country['Code'],
                    'name' => $country['Name']
                ];
                $hotelcountry =  DB::table('tbo_hotels_countries')->where('code', $countryData['code'])->first();
                if(empty($hotelcountry))
                {
                    $countryData['created_at'] = now();
                    TboHotelsCountry::insert($countryData);
                }
                else{
                    $countryData['updated_at'] = now();
                    TboHotelsCountry::where('code', $countryData['code'])->update($countryData);
                }
            }
        }

        
    }

    public function  dumpTBOCitydump()
    {
        // echo phpinfo();exit;
        // ini_set('max_execution_time', 1000);
        header('Cache-Control: max-age=0,no-store');
        $countries = TboHotelsCountry::where('is_city_dumped', 0)->limit(10)->get();
         
        foreach($countries as $country)
        {
            $cityListUrl = env('TBO_HOTEL_URL') . "CityList";
            // dd($country);
            $postArray = array('CountryCode' => $country->code);
            $cities = $this->TBOApi($cityListUrl, 'post' , $postArray);
            // dd($cities);
            if($cities['Status']['Code'] == 200)
            {
                //cities list
                $citiesList = $cities['CityList'];
                // dd(count($citiesList));
                foreach($citiesList as $citydetails)
                {
                    $city = [];
                    $cityspliter = explode("," ,$citydetails['Name']);
                    $city = [
                        'country_code' => $country->code,
                        'country_name' => $country->name,
                        'code' => $citydetails['Code'],
                        'name' => $cityspliter[0],
                        'state_name' => isset($cityspliter[1]) ? ltrim($cityspliter[1]) :  NULL,
                    ];
                    // dd($city);
                    $citydata =  DB::table('tbo_hotels_cities')->where('code', $city['code'])->first();
                    if(empty($citydata))
                    {
                        $city['created_at'] = now();
                        TboHotelsCity::insert($city);
                    }
                    else{
                        $city['updated_at'] = now();
                        TboHotelsCity::where('code', $city['code'])->update($city);
                    }   
                }
            }
          
          TboHotelsCountry::where('id', $country->id)->update(array('is_city_dumped' => 1));
          echo '<br>';
          echo $country->name." country cities dumped successfully ";
            
        }
        

        
    }

    public function dumpTBOHotelsCode()
    {
        header( 'Cache-Control: max-age=0,no-store');
        $Url = env('TBO_HOTEL_URL') . "hotelcodelist";
        $hotelCodes = $this->TBOApi($Url, 'get');
       
        $ChunkedhotelCodes = array_chunk($hotelCodes['HotelCodes'],50);
        foreach (array_chunk($ChunkedhotelCodes,500) as $chunk)
        {
            $insert = [];
            foreach ($chunk as $indiviualChunk) {
                $insert[] = ['hotel_codes_set'=>implode(',',$indiviualChunk)];
            }
            DB::table('tbo_hotels_codes')->insert($insert);
        }
        echo "Hotel Codes dumped successfully";
    }

    public function getStaticHotelsdata()
    {
        header( 'Cache-Control: max-age=0,no-store');
        $hoteldetailsUrl = env('TBO_HOTEL_URL') . "Hoteldetails";
        $hotelcodesList = TboHotelsCode::where('hotel_dumped' , 0)->limit(3)->get();

        foreach($hotelcodesList as $hotelcodes)
        {
            $postArray = array( "Hotelcodes" => $hotelcodes->hotel_codes_set,"Language"=> "en","IsDetailedResponse" => "true");
            $hotels = $this->TBOApi($hoteldetailsUrl, 'post' ,$postArray);

            if($hotels['Status']['Code'] == 200)
            {
                $hotelsList = $hotels['HotelDetails'];
                
                foreach($hotelsList as $hotel)
                {
                    $hotalData = [];
                    if(!empty($hotel))
                    {
                     
                        $hotalData = [
                            'hotel_code' => $hotel['HotelCode'] ?? null,
                            'hotel_name' => $hotel['HotelName']?? null,
                            'hotel_rating' => $hotel['HotelRating'] ?? null,
                            'address' => $hotel['Address'] ?? null,
                            // 'attractions' => isset($hotel['Attractions']) ? json_encode($hotel['Attractions']) : NULL ,
                            'country_name' => $hotel['CountryName'] ?? null,
                            'country_code' => $hotel['CountryCode'] ?? null,
                            'description' => $hotel['Description'] ?? null,
                            'fax_number' => $hotel['FaxNumber'] ?? null,
                            'hotel_facilities' => isset($hotel['HotelFacilities']) ? json_encode($hotel['HotelFacilities']) : NULL ,
                            'map' => $hotel['Map'] ?? null,
                            'phone_number' => $hotel['PhoneNumber'] ?? null,
                            'pin_code' => $hotel['PinCode'] ?? null,
                            'hotel_website_url' => $hotel['HotelWebsiteUrl'] ?? null,
                            'city_name' => $hotel['CityName'] ?? null,
                            'city_code' => $hotel['CityId'] ?? null,
                            'images' => isset($hotel['Images']) ? json_encode($hotel['Images']) : NULL ,
                            'check_in' => $hotel['CheckInTime'] ?? null,
                            'check_out' => $hotel['CheckOutTime'] ?? null,
                        ];
                        // dd($hotalData);
                        //                         DB::enableQueryLog();
                        // $user = DB::table('tbo_hotels')->where('hotel_code', $hotalData['hotel_code'])->updateOrInsert($hotalData);
                        // $query = DB::getQueryLog();
                        // dd($query);

                       $hotelcheck =  DB::table('tbo_hotels')->where('hotel_code', $hotalData['hotel_code'])->first();
                       if(empty($hotelcheck))
                       {
                        $hotalData['created_at'] = now();
                            TboHotel::insert($hotalData);
                       }
                       else{
                        $hotalData['updated_at'] = now();
                        TboHotel::where('hotel_code', $hotalData['hotel_code'])->update($hotalData);
                       }
                    //    exit;
                        
                    }

                    
                }

                

            }
            DB::table('tbo_hotels_codes')->where('id', $hotelcodes->id)->update(['hotel_dumped' => 1]);

            echo $hotelcodes->id." th row hotels Codes with details dumped";



        }
    }

    public function WebBedsHoteldata(){

        header( 'Cache-Control: max-age=0,no-store');
        $hotelUrl = env('WEBBEDS_URL') ;
        $cityDetails = WebbedsCity::where(['is_hotel_data_dumped' => 'no' , 'fetch_cycle' => null])->limit(1)->get();
        $searchController = new SearchController();

        if(!empty($cityDetails)){
            
            foreach ($cityDetails as $key => $city) {
                WebbedsCity::where('code', $city->code)->update(['cycle_update_on' => now()]);
                $data['cityCode'] = $city->code;
                $data['from'] = Carbon::today()->format('Y-m-d');
                $data['to'] = Carbon::tomorrow()->format('Y-m-d');
                $HotelsInfo = $searchController->saticDatafetch($data);
                
                if($HotelsInfo['success'])
                {
                    if(isset($HotelsInfo['hotels']['hotel'])){
                        $HotelsInfo['hotels']['hotel'] = nodeConvertion($HotelsInfo['hotels']['hotel']);
                        foreach($HotelsInfo['hotels']['hotel'] as $hotelInfo)
                        {
                            $this->storeHotel($hotelInfo);
                        }
                    }
                    WebbedsCity::where('code', $city->code)->update(['is_hotel_data_dumped' => 'yes' , 'last_dump_on' => now() ,'last_dump_staus' => 'success']);
                    Log::info("dumping successfull for city code ".$city->name);
                    echo "dumping successfull for city code ".$city->name;
                }else{
                    WebbedsCity::where('code', $city->code)->update(['is_hotel_data_dumped' => 'no' , 'last_dump_on' => now() ,'last_dump_staus' => 'failure']);
                    Log::error("dumping failed for city code ".$city->name);
                    echo "dumping failed for city code ".$city->name;
                }
            }
        }
    }

    public function storeHotel($hotelInfo){

        $hotelcheck = WebbedsHotel::where('hotel_code', $hotelInfo['@attributes']['hotelid'])->first();
        if(empty($hotelcheck)){
            $rating = 0;
            if($hotelInfo['rating'] == 560){
                $rating = 2;
            }elseif($hotelInfo['rating'] == 561){
                $rating = 3;                        
            }elseif($hotelInfo['rating'] == 562){
                $rating = 4;                        
            }elseif($hotelInfo['rating'] == 563){
                $rating = 5;                        
            }else{
                $rating = 1;
            }

            $images = [];

            if(isset($hotelInfo['images']['hotelImages']['image'])){     
            $hotelInfo['images']['hotelImages']['image'] = nodeConvertion($hotelInfo['images']['hotelImages']['image']);
                foreach($hotelInfo['images']['hotelImages']['image'] as $image){
                    $images[] = $image['url'];
                }
            }

            $ammenities = [];


            if(isset($hotelInfo['amenitie']['language'])){
                $hotelInfo['amenitie']['language']['amenitieItem'] = nodeConvertion($hotelInfo['amenitie']['language']['amenitieItem']);
                foreach($hotelInfo['amenitie']['language']['amenitieItem'] as $facility){
                    $ammenities[] = $facility['@content'];
                }
            }
            $map = null;
            if(isset($hotelInfo['geoPoint']['lat']) && isset($hotelInfo['geoPoint']['lng']) && $hotelInfo['geoPoint']['lat'] != '' && $hotelInfo['geoPoint']['lng'] != ''){
                $map = $hotelInfo['geoPoint']['lat'].'|'.$hotelInfo['geoPoint']['lng'];
            }
            $phone_number = null;
            if(isset($hotelInfo['hotelPhone']) ){
                if(is_array($hotelInfo['hotelPhone']) ){
                    if(!empty($hotelInfo['hotelPhone'][0])){
                        $phone_number = $hotelInfo['hotelPhone'][0];
                    }
                }else{
                    $phone_number = $hotelInfo['hotelPhone'];
                }
            }

            $hoteldetails = [
                'hotel_code' => $hotelInfo['@attributes']['hotelid'] ?? null,
                'preferred' => $hotelInfo['@attributes']['preferred'] ?? null,
                'exclusive' => $hotelInfo['@attributes']['exclusive'] ?? null,
                'hotel_name' => $hotelInfo['hotelName'] ?? null,
                'hotel_rating' => $rating ?? null,
                'address' => $hotelInfo['address'] ?? null,
                'country_name' => $hotelInfo['countryName'] ?? null,
                'country_code' => $hotelInfo['countryCode'] ?? null,
                'description' => $hotelInfo['description1']['language']['@content'] ??null,
                'map' => $map,
                'phone_number' => $phone_number,
                'pin_code' => $hotelInfo['zipCode']??null,
                'city_name' => $hotelInfo['cityName']??null,
                'city_code' => $hotelInfo['cityCode']??null,
                'images' => implode(',', $images) ?? null,
                'check_in' => $hotelInfo['hotelCheckIn']??null,
                'check_out' => $hotelInfo['hotelCheckOut']??null ,
                'thumbnail' => $hotelInfo['images']['hotelImages']['thumb'] ?? null,
                'hotel_facilities' => implode(',', $ammenities) ?? null,
                'lastUpdated' => $hotelInfo['lastUpdated'] ?? null
            ];
            
            WebbedsHotel::insert($hoteldetails);
        }

        
    }

    public function DidaStoreCity()
    {
        header('Cache-Control: max-age=0,no-store');
        

        // Fetch countries that need city data
        $countries = WebbedsCountry::where('dida_city_dumped', 0)->where('alpha_code', '!=', null)->limit(15)->get();

        foreach ($countries as $country) {
            // Fetch city list from Dida API
            $cityList = $this->DadiApiStaticData([
                'query'       => ['countryCode' => $country->alpha_code], // dynamic country
                'end_point'   => 'region/destinations',
                'method'      => 'GET'
            ]);
          

            if ($cityList['status'] && isset($cityList['response']['data'])) {
                if (count($cityList['response']['data']) != 0) {
                    $cities = $cityList['response']['data'];

                    // Split into smaller chunks to prevent memory overload
                    $cityChunks = array_chunk($cities, 100);
                    //dd($cityChunks);
                

                    foreach ($cityChunks as $chunk) {
                        $insertData = [];

                        foreach ($chunk as $cityInfo) {
                            // echo "ddd";
                            $insertData[] = [
                                'dida_code'     => $cityInfo['code'] ?? null,
                                'name'          => $cityInfo['name'] ?? null,
                                'long_name'     => $cityInfo['longName'] ?? null,
                                'country_code'  => $country->alpha_code ?? null,
                                'country_name'  => $country->name ?? null,
                                'is_dida'        => 1,
                                'created_at'    => now(),
                                'updated_at'    => now(),
                            ];
                        }
                        //dd($insertData);

                        // ✅ Bulk insert all 100 cities in one go
                        if (!empty($insertData)) {
                            HotelCity::insert($insertData);
                        }
                    }
                    echo "Inserted cities for country: {$country->name}\n";
                    
                    
                }else{
                    echo "No cities found for country: {$country->name}\n";

                }
                
                // ✅ Mark this country as processed
                $country->update(['dida_city_dumped' => 1]);

              
            } else {
                echo "No data found or error for country: {$country->name}\n";
            }
            echo "<br>";
        }

        echo "✅ All cities inserted successfully.\n";
    }

    public function DidaStoreHotelList()
    {
        header('Cache-Control: max-age=0,no-store');
        

        // Fetch countries that need city data
        $countries = WebbedsCountry::where('dida_hotel_dumped', 0)->where('alpha_code', '!=', null)->limit(15)->get();
        //$countries = WebbedsCountry::where('dida_hotel_dumped', 0)->where('id', 104)->where('alpha_code', '!=', null)->limit(15)->get();
        //where('dida_city_dumped', 0)->

        foreach ($countries as $country) {
            // Fetch city list from Dida API
            $hotelList = $this->DadiApiStaticData([
                'query'       => ['countryCode' => $country->alpha_code], // dynamic country
                'end_point'   => 'hotel/list',
                'method'      => 'GET'
            ]);

            if ($hotelList['status'] && isset($hotelList['response']['data'])) {
                if (count($hotelList['response']['data']) != 0) {
                    $cities = $hotelList['response']['data'];

                    // Split into smaller chunks to prevent memory overload
                    $cityChunks = array_chunk($cities, 200);
                    foreach ($cityChunks as $chunk) {
                        $insertData = [];

                        foreach ($chunk as $hotelId) {
                            $insertData[] = [
                                'hotel_id'          => $hotelId,
                                'country_alpha_code'  => $country->alpha_code,
                                'created_at'    => now()
                            ];
                        }
                        //dd($insertData);

                        // ✅ Bulk insert all 100 cities in one go
                        if (!empty($insertData)) {
                            DidaHotelList::insert($insertData);
                        }
                    }
                    echo "Hotel ID Inserted for country: {$country->name}\n";
                }else{
                    echo "No Hotel ID found for country: {$country->name}\n";
                }
                
                // ✅ Mark this country as processed
                $country->update(['dida_hotel_dumped' => 1 , 'hotel_list_dumped_on' => now()]);
              
            } else {
                echo "No data found or error for country: {$country->name}\n";
            }
            echo "<br>";
        }

        echo "✅ All Hotel ID  inserted successfully.\n";
    }

    public function DidaStoreHotelDetails()
    {
        header('Cache-Control: max-age=0,no-store');

        // Fetch hotels needing detail dump
        $hotelList = 
        //DidaHotelList::where('is_hotel_details_dumped', 0)
        //DidaHotelList::where('hotel_id', 2788658)
        DidaHotelList::where('is_hotel_details_dumped', 0)
            ->where("country_alpha_code" ,"AE")
            ->whereNotNull('hotel_id')
            ->limit(100)
            ->get();
        
        
            
    

        if ($hotelList->isEmpty()) {
            return response()->json(['message' => 'No pending hotel details to process.']);
        }

        $hotelList->chunk(50)->each(function ($chunk, $chunkIndex) {
            $hotelIds = $chunk->pluck('hotel_id')->toArray();
  
            
            

            $payload = [
                'language' => 'en-US',
                'hotelIds' => $hotelIds,
            ];

            //try {
                // 🔹 Call API
                $apiResponse = $this->DadiApiStaticData([
                    'end_point' => 'hotel/details',
                    'method'    => 'POST',
                    'params'    => $payload,
                ]);
                //dd($apiResponse);

                if (!$apiResponse['status']) {
                    \Log::warning("Chunk {$chunkIndex} failed: " . $apiResponse['message']);
                    return;
                }
                //dd($apiResponse['response']);

                $hotels = $apiResponse['response']['data'] ?? [];

                foreach ($hotels as $hotel) {
                  

                    $imagesCsv = null;
                    $thumbnail = null;
                    $hotelImages = null;
                    if(isset($hotel['images']) && !empty($hotel['images'])){
                        $hotelImages = array_column(
                            array_filter($hotel['images'], function ($img) use (&$thumbnail) {
                                if (($img['isDefault'] ?? false) === true) {
                                    $thumbnail = $img['url'];
                                    return false;
                                }
                                return true;
                            }),
                            'url'
                        ) ?: null;
                    }
                    

                    if($thumbnail == null && !empty($hotelImages)){
                        $thumbnail = $hotelImages[0];
                    }
                    if(!empty($hotelImages)){
                        $imagesCsv = implode(',', $hotelImages);
                    }
                    
                    if(empty($imagesCsv) && (!empty($thumbnail)) ){
                        $imagesCsv = $thumbnail;
                    }
                    
                //    dd([
                //             'language'          => $hotel['language'] ?? 'en-US',
                //             'name'              => $hotel['name'] ?? null,
                //             'country_code'      => $hotel['location']['country']['code'] ?? null,
                //             'country_name'      => $hotel['location']['country']['name'] ?? null,
                //             'destination_code'  => $hotel['location']['destination']['code'] ?? null,
                //             'destination_name'  => $hotel['location']['destination']['name'] ?? null,
                //             'longitude'         => $hotel['location']['coordinate']['longitude'] ?? null,
                //             'latitude'          => $hotel['location']['coordinate']['latitude'] ?? null,
                //             'state_code'        => $hotel['location']['stateCode'] ?? null,
                //             'address'           => $hotel['location']['address'] ?? null,
                //             'telephone'         => $hotel['telephone'] ?? null,
                //             'star_rating'       => $hotel['starRating'] ?? null,
                //             'zip_code'          => $hotel['zipCode'] ?? null,
                //             'images'            => $imagesCsv ?? null,
                //             'thumbnail'         => $thumbnail ?? null
                //         ]);
                   
                    //dd($hotel ,$thumbnail ,$imagesCsv);
                    // 🔹 Flatten JSON and save to DB
                    $hotelInfo = DidaHotel::updateOrCreate(
                        ['hotel_id' => $hotel['id']],
                        [
                            'language'          => $hotel['language'] ?? 'en-US',
                            'name'              => $hotel['name'] ?? null,
                            'country_code'      => $hotel['location']['country']['code'] ?? null,
                            'country_name'      => $hotel['location']['country']['name'] ?? null,
                            'destination_code'  => $hotel['location']['destination']['code'] ?? null,
                            'destination_name'  => $hotel['location']['destination']['name'] ?? null,
                            'longitude'         => $hotel['location']['coordinate']['longitude'] ?? null,
                            'latitude'          => $hotel['location']['coordinate']['latitude'] ?? null,
                            'state_code'        => $hotel['location']['stateCode'] ?? null,
                            'address'           => $hotel['location']['address'] ?? null,
                            'telephone'         => $hotel['telephone'] ?? null,
                            'star_rating'       => $hotel['starRating'] ?? null,
                            'zip_code'          => $hotel['zipCode'] ?? null,
                            'images'            => $imagesCsv ?? null,
                            'thumbnail'         => $thumbnail ?? null
                        ]
                    );
                   
                }

                // 🔹 Mark hotels as dumped
                DidaHotelList::whereIn('hotel_id', $hotelIds)
                    ->update(['is_hotel_details_dumped' => 1]);

            // } catch (\Exception $e) {
            //     \Log::error("Chunk {$chunkIndex} processing failed", [
            //         'error' => $e->getMessage(),
            //         'hotel_ids' => $hotelIds,
            //     ]);
            // }

            // Optional: prevent rate limiting
            // sleep(1);
        });

        return response()->json(['message' => 'Hotel details imported successfully.']);
    }


    // public function addingDidaCodes(){
    //     header('Cache-Control: max-age=0,no-store');
    //     $didaCityList = DidaCity::where("is_moved", 0)->limit(100)->get();
    //     dd($didaCityList);

    //     foreach($didaCityList as $city){

    //         $webbedsCity = WebbedsCity::where(['name' => $city->name , 'country_name' => $city->country])->get();
          
    //         if(count($webbedsCity) > 0){
    //             // if(count($webbedsCity) == 1){
    //             //     WebbedsCity::where('id', $webbedsCity->id)->update(['dida_code' => $city->code , 'is_dida' => 1 , 'updated_at' => now(),'long_name' => $city->longName]);
    //             // }else{
    //             //     foreach($webbedsCity as $webbedCityData){
    //             //         if($webbedCityData->code != null){
    //             //             DidaCity::where('id', $city->id)->update(['webbeds_city_code' => $webbedCityData->code]);
    //             //             echo "Webbeds city code added for city: {$city->name}\n";
    //             //         }
    //             //     }
    //             // }
    //             if(count($webbedsCity) == 1){
    //                 WebbedsCity::where('id', $webbedsCity->first()->id)->update(['dida_code' => $city->code , 'is_dida' => 1 , 'updated_at' => now(),'long_name' => $city->longName]);
    //             }else{

    //             }
                
    //         }else{

    //             // adding new
    //             $newWebbedsCity = [
    //                 'name'          => $city->name,
    //                 'country_name'  => $city->country,
    //                 'country_code'  => $city->countryCode,
    //                 'dida_code'     => $city->code, // code will be null for now, can be updated later
    //                 'long_name'     => $city->longName,
    //                 'country_code'  => $city->countryCode,
    //                 'is_dida'       => 1,
    //                 'created_at'    => now(),
    //                 'updated_at'    => now()
    //             ];
    //             WebbedsCity::create($newWebbedsCity);
    //         }

    //         $didaCityList->update(['is_moved' => 1]);

           
    //     }

    //     echo "✅ All DIDA codes added successfully.\n";
    // }

    public function GtsStoreHotelIds(Request $request)
    {
        set_time_limit(0);
        header('Cache-Control: max-age=0,no-store');

        $lastSyncDate = '1970-01-01';
        $idType =  'New';
        $nextKey = null;
        $maxPages = 50;


        $pageCount = 0;
        $totalInserted = 0;

        do {
            $queryParams = [
                'lastSyncDate' => $lastSyncDate,
                'idType'       => $idType,
            ];

            if ($nextKey) {
                $queryParams['nextKey'] = $nextKey;
            }else{
                $getLastHotelId = GtsHotelList::orderBy('id', 'desc')->first();
                if($getLastHotelId){
                    $queryParams['nextKey'] = $getLastHotelId->hotel_id;
                }
             
            }

            $response = $this->GTSStaticApi([
                'end_point' => 'hotelcontent/ids',
                'method'    => 'GET',
                'query'     => $queryParams
            ]);

            if (!$response['status']) {
                echo "❌ Failed to fetch page " . ($pageCount + 1) . ": " . $response['message'] . "<br>";
                break;
            }

            $data = $response['response'];
            $ids = $data['ids'] ?? [];
            $nextKey = $data['nextKey'] ?? null;

            if (empty($ids)) {
                echo "ℹ️ No IDs returned in page " . ($pageCount + 1) . ". Ending loop.<br>";
                break;
            }

            $insertData = [];
            foreach ($ids as $hotelId) {
                $insertData[] = [
                    'hotel_id'                => $hotelId,
                    'is_hotel_details_dumped' => 0,
                    'created_at'              => now(),
                    'updated_at'              => now()
                ];
            }

            $chunks = array_chunk($insertData, 200);
            foreach ($chunks as $chunk) {
                DB::table('gts_hotel_lists')->insertOrIgnore($chunk);
            }

            $insertedInThisPage = count($ids);
            $totalInserted += $insertedInThisPage;
            $pageCount++;

            echo "✅ Page {$pageCount} processed. Fetched {$insertedInThisPage} IDs. NextKey: " . ($nextKey ?? 'NULL') . "<br>";
            if (ob_get_level() > 0) {
                ob_flush();
            }
            flush();

            if ($maxPages && $pageCount >= $maxPages) {
                echo "🛑 Reached maximum page limit of {$maxPages}. Remaining nextKey: {$nextKey}<br>";
                break;
            }

        } while ($nextKey !== null);

        return response()->json([
            'status'            => 'success',
            'pages_processed'   => $pageCount,
            'total_ids_fetched' => $totalInserted,
            'nextKey'           => $nextKey
        ]);
    }

    // public function GtsStoreHotelDetails(Request $request)
    // {
    //     set_time_limit(0);
    //     header('Cache-Control: max-age=0,no-store');

    //     $limit = $request->input('limit') ?? 100;

    //     // Fetch hotel IDs needing detail dump
    //     $hotelList = GtsHotelList::where('is_hotel_details_dumped', 0)
    //         ->whereNotNull('hotel_id')
    //         ->limit($limit)
    //         ->get();
  
    //     if ($hotelList->isEmpty()) {
    //         return response()->json(['status' => 'success', 'message' => 'No pending hotel details to process.']);
    //     }

    //     $processedCount = 0;

    //     $hotelList->chunk(50)->each(function ($chunk, $chunkIndex) use (&$processedCount) {
    //         $hotelIds = $chunk->pluck('hotel_id')->toArray();

    //         $payload = [
    //             'hotelIds' => $hotelIds,
    //         ];
           
          

    //         $apiResponse = $this->GTSStaticApi([
    //             'end_point' => 'hotelcontent',
    //             'method'    => 'GET',
    //             'query'    => $payload,
    //         ]);
           

    //         if (!$apiResponse['status']) {
    //             \Log::warning("GTS Chunk {$chunkIndex} failed: " . $apiResponse['message']);
    //             echo "❌ Chunk " . ($chunkIndex + 1) . " failed: " . $apiResponse['message'] . "<br>";
    //             return;
    //         }

    //         $hotels = $apiResponse['response']['hotels'] ?? [];

    //         foreach ($hotels as $hotel) {
                
    //             if (empty($hotel['id'])) {
    //                 continue;
    //             }
                

    //             $addrParts = [];
    //             $addrObj = $hotel['contact']['address'] ?? [];
    //             if (!empty($addrObj['line1'])) {
    //                 $addrParts[] = $addrObj['line1'];
    //             }
    //             if (!empty($addrObj['city']['name'])) {
    //                 $addrParts[] = $addrObj['city']['name'];
    //             }
    //             if (!empty($addrObj['state']['name'])) {
    //                 $addrParts[] = $addrObj['state']['name'];
    //             }
    //             if (!empty($addrObj['postalCode'])) {
    //                 $addrParts[] = $addrObj['postalCode'];
    //             }
    //             if (!empty($addrObj['country']['name'])) {
    //                 $addrParts[] = $addrObj['country']['name'];
    //             }
    //             $address = implode(', ', $addrParts);
    //             $roomsInfo = null;
    //             if(!empty($hotel['rooms'])){
    //                 $rooms = $hotel['rooms'];
    //                 $roomArray = array_map(function ($room) {
    //                     $beds = collect($room['beds'])->map(function ($bed) {
    //                         return $bed['count'] . ' ' . $bed['type'];
    //                     })->implode(', ');
    //                     return [
    //                         'id'   => $room['id'],
    //                         'type' => $room['type'],
    //                         'bed'  => $beds,
    //                     ];
    //                 }, $rooms);
    //                 // Store in database
    //                 $roomsInfo = json_encode($roomArray);
    //             }
               
                

    //             GtsHotel::updateOrCreate(
    //                 ['hotel_id' => $hotel['id']],
    //                 [
    //                     'country_code' => $hotel['contact']['address']['country']['code'] ?? null,
    //                     'country_name' => $hotel['contact']['address']['country']['name'] ?? null,
    //                     'longitude'    => $hotel['geoCode']['long'] ?? null,
    //                     'latitude'     => $hotel['geoCode']['lat'] ?? null,
    //                     'name'         => $hotel['name'] ?? null,
    //                     'star_rating'  => $hotel['starRating'] ?? null,
    //                     'address'      => $address,
    //                     'telephone'    => $hotel['contact']['phone'] ?? null,
    //                     'zipcode'      => $hotel['contact']['address']['postalCode'] ?? null,
    //                     'thumbnail'    => $hotel['heroImage'] ?? null,
    //                     'checkin'      => $hotel['checkinInfo']['beginTime'] ?? null,
    //                     'checkout'     => $hotel['checkoutInfo']['time'] ?? null,
    //                     'rooms'        => $roomsInfo
    //                 ]
    //             );

    //             $processedCount++;
    //         }

    //         // Mark this chunk's hotel IDs as dumped
    //         GtsHotelList::whereIn('hotel_id', $hotelIds)
    //             ->update(['is_hotel_details_dumped' => 1]);

    //         echo "✅ Chunk " . ($chunkIndex + 1) . " processed. Saved details for " . count($hotels) . " hotels.<br>";
    //         if (ob_get_level() > 0) {
    //             ob_flush();
    //         }
    //         flush();
    //     });

    //     return response()->json([
    //         'status'          => 'success',
    //         'processed_count' => $processedCount,
    //     ]);
    // }
    // public function GtsStoreHotelDetails(Request $request)
    // {
    //     set_time_limit(0);
    //     header('Cache-Control: max-age=0,no-store');

    //     $limit = 500;

    //     // Fetch hotel IDs needing detail dump
    //     $hotelList = GtsCityHotel::where('is_hotel_details_dumped', 0)
    //         ->whereNotNull('hotel_id')
    //         ->limit($limit)
    //         ->get();
  
    //     if ($hotelList->isEmpty()) {
    //         return response()->json(['status' => 'success', 'message' => 'No pending hotel details to process.']);
    //     }

    //     $processedCount = 0;

    //     $hotelList->chunk(50)->each(function ($chunk, $chunkIndex) use (&$processedCount) {
    //         $hotelIds = $chunk->pluck('hotel_id')->toArray();

    //         $payload = [
    //             'hotelIds' => $hotelIds,
    //         ];
            
           
          

    //         $apiResponse = $this->GTSStaticApi([
    //             'end_point' => 'hotelcontent',
    //             'method'    => 'GET',
    //             'query'    => $payload,
    //         ]);
          

    //         if (!$apiResponse['status']) {
    //             \Log::warning("GTS Chunk {$chunkIndex} failed: " . $apiResponse['message']);
    //             echo "❌ Chunk " . ($chunkIndex + 1) . " failed: " . $apiResponse['message'] . "<br>";
    //             return;
    //         }

    //         $hotels = $apiResponse['response']['hotels'] ?? [];

    //         foreach ($hotels as $hotel) {
                
    //             if (empty($hotel['id'])) {
    //                 continue;
    //             }
                

    //             $addrParts = [];
    //             $addrObj = $hotel['contact']['address'] ?? [];
    //             if (!empty($addrObj['line1'])) {
    //                 $addrParts[] = $addrObj['line1'];
    //             }
    //             if (!empty($addrObj['city']['name'])) {
    //                 $addrParts[] = $addrObj['city']['name'];
    //             }
    //             if (!empty($addrObj['state']['name'])) {
    //                 $addrParts[] = $addrObj['state']['name'];
    //             }
    //             if (!empty($addrObj['postalCode'])) {
    //                 $addrParts[] = $addrObj['postalCode'];
    //             }
    //             if (!empty($addrObj['country']['name'])) {
    //                 $addrParts[] = $addrObj['country']['name'];
    //             }
    //             $address = implode(', ', $addrParts);
    //             $roomsInfo = null;
    //             // if(!empty($hotel['rooms'])){
    //             //     $rooms = $hotel['rooms'];
    //             //     $roomArray = array_map(function ($room) {
    //             //         $beds = collect($room['beds'])->map(function ($bed) {
    //             //             return $bed['count'] . ' ' . $bed['type'];
    //             //         })->implode(', ');
    //             //         return [
    //             //             'id'   => $room['id'],
    //             //             'type' => $room['type'],
    //             //             'bed'  => $beds,
    //             //         ];
    //             //     }, $rooms);
    //             //     // Store in database
    //             //     $roomsInfo = json_encode($roomArray);
    //             // }
               
                

    //             $cityHotel = $chunk->where('hotel_id', $hotel['id'])->first();

    //             GtsHotel::updateOrCreate(
    //                 ['hotel_id' => $hotel['id']],
    //                 [
    //                     'city_code'    => $cityHotel ? $cityHotel->city_code : null,
    //                     'country_code' => $hotel['contact']['address']['country']['code'] ?? null,
    //                     'country_name' => $hotel['contact']['address']['country']['name'] ?? null,
    //                     'longitude'    => $hotel['geoCode']['long'] ?? null,
    //                     'latitude'     => $hotel['geoCode']['lat'] ?? null,
    //                     'name'         => $hotel['name'] ?? null,
    //                     'star_rating'  => $hotel['starRating'] ?? null,
    //                     'address'      => $address,
    //                     'telephone'    => $hotel['contact']['phone'] ?? null,
    //                     'zipcode'      => $hotel['contact']['address']['postalCode'] ?? null,
    //                     'thumbnail'    => $hotel['heroImage'] ?? null,
    //                     'checkin'      => $hotel['checkinInfo']['beginTime'] ?? null,
    //                     'checkout'     => $hotel['checkoutInfo']['time'] ?? null,
    //                     // 'rooms'        => $roomsInfo
    //                 ]
    //             );

    //             $processedCount++;
    //         }

    //         // Mark this chunk's hotel IDs as dumped
    //         GtsCityHotel::whereIn('hotel_id', $hotelIds)
    //             ->update(['is_hotel_details_dumped' => 1]);

    //         echo "✅ Chunk " . ($chunkIndex + 1) . " processed. Saved details for " . count($hotels) . " hotels.<br>";
    //         if (ob_get_level() > 0) {
    //             ob_flush();
    //         }
    //         flush();
    //     });

    //     return response()->json([
    //         'status'          => 'success',
    //         'processed_count' => $processedCount,
    //     ]);
    // }
    public function GtsStoreHotelDetails(Request $request)
    {
        set_time_limit(0);
        header('Cache-Control: max-age=0,no-store');

        $limit     = 600;
        $chunkSize = 50;

        //    $hotelList = GtsCityHotel::query()
        //                 // ->select(['hotel_id', 'city_code'])
        //                 ->select(['hotel_id'])
        //                 ->where('is_hotel_details_dumped', 0)
        //                 ->whereNotNull('hotel_id')
        //                 ->groupBy('hotel_id')
        //                 ->orderBy('id','ASC')
        //                 ->limit($limit)
        //                 ->get();
        $hotelList = GtsCityHotel::query()
        ->select([
            'hotel_id',
            DB::raw('MIN(id) AS first_id')
        ])
        ->where('is_hotel_details_dumped', 0)
        ->whereNotNull('hotel_id')
        ->groupBy('hotel_id')
        ->orderBy('first_id', 'asc')
        ->limit($limit)
        ->get();
        // dd($hotelList);
            
           

        if ($hotelList->isEmpty()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'No pending hotel details to process.',
            ]);
        }


        $processedCount = 0;

        foreach ($hotelList->chunk($chunkSize) as $chunkIndex => $chunk) {
          

            $hotelIds = $chunk
                ->pluck('hotel_id')
                ->filter()
                ->unique()
                ->values()
                ->toArray();
             // dd($hotelIds,$chunk
              //  ->pluck('hotel_id'));
            if (empty($hotelIds)) {
                continue;
            }

            /*
            * Create hotel_id => city_code map.
            *
            * This avoids:
            * $chunk->where('hotel_id', $hotel['id'])->first()
            *
            * inside the hotel loop.
            */
            // $cityCodeMap = $chunk
            //     ->pluck('city_code', 'hotel_id')
            //     ->toArray();
           
            $apiResponse = $this->GTSStaticApi([
                'end_point' => 'hotelcontent',
                'method'    => 'GET',
                'query'     => [
                    'hotelIds' => $hotelIds,
                ],
            ]);
            //dd($hotelIds ,$apiResponse);

            if (!$apiResponse['status']) {

                \Log::warning(
                    "GTS Chunk {$chunkIndex} failed: " .
                    $apiResponse['message']
                );

                continue;
            }

            $hotels = $apiResponse['response']['hotels'] ?? [];

            if (empty($hotels)) {
                continue;
            }

            $now     = now();
            $upserts = [];
            $returnedHotelIds = [];

            foreach ($hotels as $hotel) {

                $hotelId = $hotel['id'] ?? null;

                if (empty($hotelId)) {
                    continue;
                }

                $returnedHotelIds[] = $hotelId;

                $address = collect([
                    $hotel['contact']['address']['line1'] ?? null,
                    $hotel['contact']['address']['city']['name'] ?? null,
                    $hotel['contact']['address']['state']['name'] ?? null,
                    $hotel['contact']['address']['postalCode'] ?? null,
                    $hotel['contact']['address']['country']['name'] ?? null,
                ])
                    ->filter(fn ($value) => !empty($value))
                    ->implode(', ');

                $upserts[] = [
                    'hotel_id'     => $hotelId,
                    // 'city_code'    => $cityCodeMap[$hotelId] ?? null,
                    'city_code'    =>  null,

                    'country_code' => $hotel['contact']['address']['country']['code'] ?? null,
                    'country_name' => $hotel['contact']['address']['country']['name'] ?? null,

                    'longitude'    => $hotel['geoCode']['long'] ?? null,
                    'latitude'     => $hotel['geoCode']['lat'] ?? null,

                    'name'         => $hotel['name'] ?? null,
                    'star_rating'  => $hotel['starRating'] ?? null,

                    'address'      => $address,

                    'telephone'    => $hotel['contact']['phone'] ?? null,
                    'zipcode'      => $hotel['contact']['address']['postalCode'] ?? null,

                    'thumbnail'    => $hotel['heroImage'] ?? null,

                    'checkin'      => $hotel['checkinInfo']['beginTime'] ?? null,
                    'checkout'     => $hotel['checkoutInfo']['time'] ?? null,

                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }

            /*
            * One bulk query instead of updateOrCreate()
            * for every hotel.
            */
            if (!empty($upserts)) {

                $upsetResult = GtsHotel::upsert(
                    $upserts,
                    ['hotel_id'],
                    [
                        //'city_code',
                        'country_code',
                        'country_name',
                        'longitude',
                        'latitude',
                        'name',
                        'star_rating',
                        'address',
                        'telephone',
                        'zipcode',
                        'thumbnail',
                        'checkin',
                        'checkout',
                        'updated_at',
                    ]
                );

                $processedCount += count($upserts);
            }

            /*
            * Mark successfully received hotels as dumped.
            *
            * This is safer than marking every requested ID as dumped.
            */
            if (!empty($hotelIds)) {

                GtsCityHotel::whereIn('hotel_id', $hotelIds)
                    ->update([
                        'is_hotel_details_dumped' => 1,
                    ]);
            }
            echo "✅ Chunk " . ($chunkIndex + 1) .
                " processed. Saved details for " .
                count($upserts) .
                " hotels.<br>";
            //dd($upsetResult,$upserts);

            

            if (ob_get_level() > 0) {
                ob_flush();
            }

            flush();
        }

        return response()->json([
            'status'          => 'success',
            'processed_count' => $processedCount,
        ]);
    }
    public function getRestelCity(){
        header( 'Cache-Control: max-age=0,no-store');
        $hotelUrl = env('RESTEL_URL') ;

        $provincia = Provincia::where(['status' => 'active', 'is_dumped' => '1'])->limit(20)->get();
        //$provincia = Provincia::where(['status' => 'active', 'id' => '1'])->limit(10)->get();
        foreach($provincia as $prov){
            //xml preparation 
            $xml = '<peticion>
                        <tipo>18</tipo>
                        <nombre>Servicio de poblaciones</nombre>
                        <agencia>Agencia prueba</agencia>
                        <parametros>
                            <codest>'.$prov->codigoProvincia.'</codest> 
                        </parametros>
                    </peticion>';
            $data['xml'] = $xml;
            $cityInfo = $this->RestelApiXmlRequestWithoutLog($data);
           
            $CountryInfo = WebbedsCountry::where('restel_code', $prov->codigoPais)->first();
            dd( $CountryInfo,$prov->codigoPais);
           
            
            if($cityInfo['success']){
                //dd($cityInfo['city']);
                foreach($cityInfo['city'] as $city){
                   //$cityInfo = WebbedsCity::where(['name'=> strtolower($city['poblidinom1']) , 'country_code' => $CountryInfo->code])->first();
                    //    if($cityInfo){
                    //         //already exist
                    //         $cityInfo->restel_city_code = $city['codpob'];
                    //         $cityInfo->restel_country_code = $CountryInfo->restel_code;
                    //         $cityInfo->restel_provincia_code = $city['deppob'];
                    //         $cityInfo->save();
                    //    }else{
                    //         //need to add new city
                    //         $newCity = new WebbedsCity();
                    //         $newCity->name = $city['poblidinom1'];
                    //         $newCity->country_name = $CountryInfo->name;
                    //         $newCity->country_code = $CountryInfo->code;
                    //         $newCity->restel_city_code = $city['codpob'];
                    //         $newCity->restel_country_code = $CountryInfo->restel_code;
                    //         $newCity->restel_provincia_code = $city['deppob'];
                    //         $newCity->save();
                    //    } 
                    $newCity = new RestelCity();
                    $newCity->name = $city['poblidinom1'];
                    $newCity->country_name = $CountryInfo->name;
                    $newCity->country_code = $CountryInfo->code;
                    $newCity->restel_city_code = $city['codpob'];
                    $newCity->restel_country_code = $CountryInfo->restel_code;
                    $newCity->restel_provincia_code = $city['deppob'];
                    $newCity->save();
                }
                $prov->is_dumped = '2';
            }else{
                $prov->is_dumped = '3';
            }
           
            $prov->save();
            Log::info("provincia " . $prov->id . "(" . $prov->nombreProvincia . ") processed successfully");
            echo "provincia " . $prov->id . "(" . $prov->nombreProvincia . ") processed successfully";
            echo "<br>";
        }
    }

    public function syncGtsCountries()
    {
        ini_set('max_execution_time', 0);
        $jsonFilePath = public_path('gtsCountries.json');
        
        if (!file_exists($jsonFilePath)) {
            return response()->json(['status' => false, 'message' => 'gtsCountries.json file not found.']);
        }

        $json = file_get_contents($jsonFilePath);
        $data = json_decode($json, true);

        $added = 0;
        $updated = 0;

        if (isset($data['countries']) && is_array($data['countries'])) {
            foreach ($data['countries'] as $countryData) {
                $gtsCode = $countryData['id'] ?? null;
                $isoCode = $countryData['country'] ?? null;
                $name = $countryData['name'] ?? null;
                
                if (!$isoCode) continue;

                $country = WebbedsCountry::where('alpha_code', $isoCode)->first();
                if ($country) {
                    $country->gts_code = $gtsCode;
                    $country->save();
                    $updated++;
                } else {
                    $newCountry = new WebbedsCountry();
                    $newCountry->alpha_code = $isoCode;
                    $newCountry->name = $name;
                    $newCountry->gts_code = $gtsCode;
                    $newCountry->save();
                    $added++;
                }
            }
            return response()->json([
                'status' => true, 
                'message' => "GTS Countries synced successfully. Added: $added, Updated: $updated"
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Invalid JSON data format.']);
    }

    public function dumpGtsCities()
    {
  
        ini_set('max_execution_time', 0);
        
        $country = WebbedsCountry::where(function($q) {
            $q->where('gts_city_dumped', 0)->orWhereNull('gts_city_dumped');
        })->whereNotNull('gts_code')->first();

        if (!$country) {
            return response()->json(['message' => 'All countries are completely dumped', 'status' => true]);
        }
        
        $countryCode = $country->alpha_code;
        $nextResultsKey = $country->next_results_key;
        
        $query = ['country' => $countryCode];
        if ($nextResultsKey) {
            $query['nextKey'] = $nextResultsKey;
        }
    

        $request = [
            'end_point' => 'hotelcontent/cities',
            'method' => 'GET',
            'query' => $query
        ];

        $apiResponse = $this->GtsApiJsonRequestWithoutLog($request);
        

       
        
        if ($apiResponse['status'] && isset($apiResponse['response'])) {
            $data = $apiResponse['response'];
            $inserted = 0;
            
            if (isset($data['cities']) && is_array($data['cities'])) {
                $citiesToUpsert = [];
                $now = now();
                foreach ($data['cities'] as $cityData) {
                    $citiesToUpsert[] = [
                        'gts_city_id' => $cityData['id'],
                        'name' => $cityData['name'] ?? null,
                        'full_name' => $cityData['fullName'] ?? null,
                        'country_code' => $cityData['country'] ?? null,
                        'country_name' => $country->name,
                    ];
                }
                
                if (!empty($citiesToUpsert)) {
                    // Ensure uniqueness in the batch to prevent SQL errors
                    $uniqueCities = collect($citiesToUpsert)->unique('gts_city_id')->toArray();
                    
                    \App\Models\GtsCity::upsert(
                        $uniqueCities,
                        ['gts_city_id'], // unique columns
                        ['name', 'full_name', 'country_code', 'country_name'] // columns to update
                    );
                    
                    $inserted = count($uniqueCities);
                }
            }
            
            if (isset($data['moreResults']) && $data['moreResults'] == true) {
                $country->next_results_key = $data['nextResultsKey'] ?? null;
                $country->save();
                
                // Add a script to auto-refresh the page to continue dumping
                echo "<script>setTimeout(function() { window.location.reload(); }, 1000);</script>";
                return "Dumped partially for {$country->name}. Inserted/Updated: {$inserted}. Next key: " . $country->next_results_key . ". Reloading...";
            } else {
                $country->gts_city_dumped = 1;
                $country->next_results_key = null;
                $country->save();
                
                // Add a script to auto-refresh the page to continue dumping the next country
                echo "<script>setTimeout(function() { window.location.reload(); }, 1000);</script>";
                return "Country {$country->name} dumped completely. Inserted/Updated: {$inserted}. Moving to next country...";
            }
        }
        
        return response()->json(['message' => "Failed to fetch from API: " . ($apiResponse['message'] ?? 'Unknown Error'), 'status' => false]);
    }

    // public function dumpGtsCityHotels()
    // {
    //     ini_set('max_execution_time', 0);
        
    //     $cities = \App\Models\GtsCity::where('is_hotel_dumped', 0)->limit(100)->get();
    //     //474456
    //     //$cities = \App\Models\GtsCity::where('gts_city_id', 474456)->limit(100)->get();
        

    //     if ($cities->isEmpty()) {
    //         return response()->json(['message' => 'All city hotels are completely dumped', 'status' => true]);
    //     }

    //     foreach ($cities as $city) {
    //         $request = [
    //             'end_point' => 'hotelcontent/' . $city->gts_city_id . '/ids',
    //             'method' => 'GET'
    //         ];

    //         $apiResponse = $this->GtsApiJsonRequestWithoutLog($request);
    //         //dd($apiResponse);
    //         if($apiResponse['status']){
    //             if (isset($apiResponse['response'])) {
    //                 $data = $apiResponse['response'];
                    
    //                 if (isset($data['ids']) && is_array($data['ids'])) {
    //                     $hotelsToInsert = [];
    //                     foreach ($data['ids'] as $hotelId) {
    //                         $hotelsToInsert[] = [
    //                             'city_name' => $city->name,
    //                             'city_code' => $city->gts_city_id,
    //                             'country_name' => $city->country_name,
    //                             'country_code' => $city->country_code,
    //                             'hotel_id' => $hotelId,
    //                             'is_hotel_details_dumped' => 0,
    //                             'created_at' => now(),
    //                             'updated_at' => now(),
    //                         ];
    //                     }
                        
    //                     if (!empty($hotelsToInsert)) {
    //                         $chunks = array_chunk($hotelsToInsert, 500);
    //                         foreach ($chunks as $chunk) {
    //                             \DB::table('gts_city_hotels')->insert($chunk);
    //                         }
    //                     }
    //                 }
    //                 // $city->is_hotel_dumped = 1;
    //                 // $city->save();
    //             } else {
    //                 \Log::error("Failed to dump hotels for city {$city->name}: " . ($apiResponse['message'] ?? 'Unknown Error'));
    //             }
    //         }
    //         $city->is_hotel_dumped = 1;
    //         $city->save();
    //     }
        
    //     //echo "<script>setTimeout(function() { window.location.reload(); }, 1000);</script>";
    //     return "Dumped hotels for 50 cities. Reloading...";
    // }
    public function dumpGtsCityHotels()
    {
        ini_set('max_execution_time', 0);

        $limit = 100;
        $insertChunkSize = 500;
        echo "<pre>";

        $cities = \App\Models\GtsCity::query()
            ->select([
                'id',
                'gts_city_id',
                'name',
                'country_name',
                'country_code',
            ])
            ->where('is_hotel_dumped', 0)
            ->limit($limit)
            ->orderBy('id' ,'ASC')
            ->get();
        
        if ($cities->isEmpty()) {
            return response()->json([
                'message' => 'All city hotels are completely dumped',
                'status'  => true,
            ]);
        }

        $processedCities = 0;
        $failedCities = 0;
        $totalHotels = 0;

        foreach ($cities as $city) {

            $apiResponse = $this->GtsApiJsonRequestWithoutLog([
                'end_point' => 'hotelcontent/' . $city->gts_city_id . '/ids',
                'method'    => 'GET',
            ]);
           

            /*
            * API failed.
            *
            * Keep is_hotel_dumped = 0 so the city
            * can be retried in the next execution.
            */
            if (!$apiResponse['status']) {

                $failedCities++;

                \Log::error(
                    "Failed to dump hotels for city {$city->name} " .
                    "({$city->gts_city_id}): " .
                    ($apiResponse['message'] ?? 'Unknown Error')
                );

                continue;
            }

            /*
            * API succeeded.
            */
            $data = $apiResponse['response'] ?? [];

            /*
            * GTS may return:
            *
            * ids => []
            * ids => null
            * ids not present
            *
            * All of these mean there are no hotels
            * for this city.
            */
            $hotelIds = $data['ids'] ?? [];

            if (!is_array($hotelIds) || empty($hotelIds)) {

                \App\Models\GtsCity::whereKey($city->id)
                    ->update([
                        'is_hotel_dumped' => 1,
                        'updated_at'      => now(),
                    ]);

                $processedCities++;

                \Log::info(
                    "No hotels found for city {$city->name} " .
                    "({$city->gts_city_id})"
                );

                continue;
            }

            /*
            * Remove empty/null IDs.
            *
            * No array_unique() because you confirmed
            * that duplicate hotel IDs will not exist.
            */
            $hotelIds = array_values(
                array_filter($hotelIds)
            );

            /*
            * If there are no valid IDs after filtering,
            * consider the city successfully processed.
            */
            if (empty($hotelIds)) {

                \App\Models\GtsCity::whereKey($city->id)
                    ->update([
                        'is_hotel_dumped' => 1,
                        'updated_at'      => now(),
                    ]);

                $processedCities++;

                continue;
            }

            /*
            * Generate timestamp once for the whole city.
            */
            $now = now();

            /*
            * Insert hotels in batches of 500.
            */
            foreach (array_chunk($hotelIds, $insertChunkSize) as $hotelIdChunk) {

                $hotelsToInsert = [];

                foreach ($hotelIdChunk as $hotelId) {

                    $hotelsToInsert[] = [
                        'city_name'               => $city->name,
                        'city_code'               => $city->gts_city_id,
                        'country_name'            => $city->country_name,
                        'country_code'            => $city->country_code,
                        'hotel_id'                => $hotelId,
                        'is_hotel_details_dumped' => 0,
                        'created_at'              => $now,
                        'updated_at'              => $now,
                    ];
                }

                /*
                * Normal bulk insert.
                *
                * No insertOrIgnore() because duplicates
                * are not expected.
                */
                \DB::table('gts_city_hotels')
                    ->insert($hotelsToInsert);

                $totalHotels += count($hotelIdChunk);
            }
            

            /*
            * Mark city as dumped only after all hotel
            * records have been inserted successfully.
            */
            \App\Models\GtsCity::whereKey($city->id)
                ->update([
                    'is_hotel_dumped' => 1,
                    'updated_at'      => $now,
                ]);

            $processedCities++;

            echo "✅ {$city->name} - {$city->id}- " .
                count($hotelIds) .
                " hotels dumped.<br>";

            if (ob_get_level() > 0) {
                ob_flush();
            }

            flush();
        }

        return response()->json([
            'status'           => true,
            'message'          => "Processed {$processedCities} cities.",
            'processed_cities' => $processedCities,
            'failed_cities'    => $failedCities,
            'total_hotels'     => $totalHotels,
        ]);
    }

    public function mergeGtsCities()
    {
        ini_set('max_execution_time', 0);
        
        $hotelCities = HotelCity::where('is_city_checked', 0)->limit(4000)->get();
        
        $countryCodes = $hotelCities->pluck('country_code')->filter()->unique()->toArray();
        $names = $hotelCities->map(function ($hc) {
            return strtolower(str_replace(' (and vicinity)', '', $hc->name));
        })->filter()->unique()->toArray();
        
        $allGtsCities = \App\Models\GtsCity::where('is_migrated', 0)
            ->whereIn('country_code', $countryCodes)
            ->whereIn(\DB::raw('LOWER(name)'), $names)
            ->get();
            
        $gtsCitiesGrouped = [];
        foreach ($allGtsCities as $gc) {
            $key = $gc->country_code . '_' . strtolower($gc->name);
            if (!isset($gtsCitiesGrouped[$key])) {
                $gtsCitiesGrouped[$key] = collect();
            }
            $gtsCitiesGrouped[$key]->push($gc);
        }

        \DB::beginTransaction();
        try {
            foreach ($hotelCities as $hotelCity) {
            
                $name = strtolower(str_replace(' (and vicinity)', '', $hotelCity->name));
                $longName = strtolower(str_replace(' (and vicinity)', '', $hotelCity->long_name));
                
                $key = $hotelCity->country_code . '_' . $name;
                $matches = $gtsCitiesGrouped[$key] ?? collect();
                
                $match = null;
                if ($matches->count() == 1) {
                    $match = $matches->first();
                } elseif ($matches->count() > 1 && !empty($longName)) {
                    $match = $matches->first(function ($city) use ($longName) {
                        return strtolower($city->full_name) == $longName;
                    });
                }
         
                
                if ($match) {
                    $hotelCity->gts_code = $match->gts_city_id;
                    $hotelCity->is_gts = 1;
                    $match->is_migrated = 1;
                    $match->save();
                    
                    // Remove matched city so it's not reused
                    $gtsCitiesGrouped[$key] = $gtsCitiesGrouped[$key]->reject(function ($c) use ($match) {
                        return $c->gts_city_id === $match->gts_city_id;
                    });
                }
                
                $hotelCity->is_city_checked = 1;
                $hotelCity->save();
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        
        return response()->json(['message' => 'GTS cities merged and updated successfully', 'status' => true]);
    }

    public function moveUnmigratedGtsCities()
    {
        ini_set('max_execution_time', 0);

        $unmigratedCities = \DB::table('gts_cities')
            ->where('is_migrated', 0)
            ->orderBy('id')
            ->limit(10)
            ->get();

        if ($unmigratedCities->isEmpty()) {
            return response()->json(['message' => 'No unmigrated cities found.', 'status' => true]);
        }

        $chunks = $unmigratedCities->chunk(1000);

        \DB::transaction(function () use ($chunks) {
            foreach ($chunks as $chunk) {
                $insertData = [];
                $migratedIds = [];

                foreach ($chunk as $city) {
                    $insertData[] = [
                        'name'         => $city->name,
                        'long_name'    => $city->full_name,
                        'country_code' => $city->country_code,
                        'country_name' => $city->country_name,
                        'created_at'   => $city->created_at,
                        'updated_at'   => $city->updated_at,
                        'is_gts'       => 1,
                        'gts_code'     => $city->gts_city_id,
                    ];
                    $migratedIds[] = $city->id;
                }

                \DB::table('hotel_cities')->insert($insertData);
                \DB::table('gts_cities')->whereIn('id', $migratedIds)->update(['is_migrated' => 1]);
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Moved ' . count($unmigratedCities) . ' unmigrated GTS cities successfully.'
        ]);
    }

}
