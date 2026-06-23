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
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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



}
