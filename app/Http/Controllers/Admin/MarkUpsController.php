<?php

namespace App\Http\Controllers\Admin;

use App\Models\MarkUp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdditionalPrice;
use App\Models\HotelAdditionalPrice;
use App\Models\HotelMarkUp;
use Illuminate\Support\Facades\Cache;

class MarkUpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = [
            'title' => __('admin.manage_markup'),
            'subTitle' => __('admin.markup_list'),
        ];
        if (!auth()->user()->can('markups-view')) {
            return view('admin.abort',compact('titles'));
        }
        $deleteRouteName = 'markups.destroy';

        //flights

        $markups = MarkUp::where('user_id' , 0)->get();

        $additionalPrices = AdditionalPrice::get();

        //hotel
        $hotelmarkups = HotelMarkUp::get();

        $hoteladditionalPrices = HotelAdditionalPrice::get();

        return view('admin.markups.index', compact('titles', 'markups', 'deleteRouteName','additionalPrices' ,'hotelmarkups' , 'hoteladditionalPrices'));
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = [
            'title' => __('admin.manage_markup'),
            'subTitle' => __('admin.markup_list'),
        ];
        if (!auth()->user()->can('markups-edit')) {
            return view('admin.abort',compact('titles'));
        }
        $editmarkup = MarkUp::find($id);

        return view('admin.markups.edit', compact('titles', 'editmarkup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('markups-edit')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'fee_type'=>'required',
            'fee_value'=>'required',
            'fee_amount'=>'required | numeric',
            'status'=> 'required',
           
        ]);

        $data = array();

        $MarkUp = MarkUp::find($id);

        $MarkUp->fee_type = $request->fee_type;
        $MarkUp->fee_value = $request->fee_value;
        $MarkUp->fee_amount = $request->fee_amount;
        $MarkUp->status = $request->status;
        $MarkUp->save();
        Cache::forget('MarkUpPrice');
        return redirect()->route('markups.index')->with('success', 'Updated Successfully');
    }

    public function additionalPriceedit($id)
    {
        $titles = [
            'title' => 'Service Chargers',
            'subTitle' => 'Service Chargers List',
        ];
        if (!auth()->user()->can('service-chargers-edit')) {
            return view('admin.abort',compact('titles'));
        }
        $editPrices = AdditionalPrice::find($id);
        // dd($editPrices);

        return view('admin.service_chargers.edit', compact('titles', 'editPrices'));
    }
    public function updateadditionalPrice(Request $request, $id)
    {
       
        if (!auth()->user()->can('service-chargers-edit')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'additional_price'=>'required | numeric',
            'status'=> 'required',
            'credit_card_percentage' => 'required | numeric',
            'wallet_price' => 'required | numeric',
           
        ]);
        $additionalPrice = AdditionalPrice::find($id);
        $additionalPrice->additional_price = $request->additional_price;
        $additionalPrice->status = $request->status;
        $additionalPrice->credit_card_percentage = $request->credit_card_percentage;
        $additionalPrice->wallet_price = $request->wallet_price;
        $additionalPrice->save();
        Cache::forget('serviceFee');
        return redirect()->route('markups.index')->with('success', 'Service Chargers Updated Successfully');
    }


           /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function hoteledit($id)
    {
        $titles = [
            'title' => __('admin.manage_markup'),
            'subTitle' => 'Manhage Hotel Markup ',
        ];
        if (!auth()->user()->can('hotel-markups-edit')) {
            return view('admin.abort',compact('titles'));
        }
        $editmarkup = HotelMarkUp::find($id);

        return view('admin.markups.hotel-edit', compact('titles', 'editmarkup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateHotelMarkupPrice(Request $request, $id)
    {
        if (!auth()->user()->can('hotel-markups-edit')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'fee_type'=>'required',
            'fee_value'=>'required',
            'fee_amount'=>'required | numeric',
            'status'=> 'required',
           
        ]);

        $data = array();

        $MarkUp = HotelMarkUp::find($id);

        $MarkUp->fee_type = $request->fee_type;
        $MarkUp->fee_value = $request->fee_value;
        $MarkUp->fee_amount = $request->fee_amount;
        $MarkUp->status = $request->status;
        $MarkUp->save();
        Cache::forget('HotelMarkUpPrice');
        return redirect()->route('markups.index')->with('success', 'Updated Successfully');
    }

    public function hoteladditionalPriceedit($id)
    {
        $titles = [
            'title' => 'Service Chargers',
            'subTitle' => 'Hotel Service Chargers List',
        ];
        if (!auth()->user()->can('hotel-service-chargers-edit')) {
            return view('admin.abort',compact('titles'));
        }
        $editPrices = HotelAdditionalPrice::find($id);
        // dd($editPrices);

        return view('admin.service_chargers.hotel-edit', compact('titles', 'editPrices'));
    }
    public function hotelupdateadditionalPrice(Request $request, $id)
    {
       
        if (!auth()->user()->can('hotel-service-chargers-edit')) {
            return view('admin.abort');
        }
      
        $this->validate($request, [
            'additional_price'=>'required | numeric',
            'status'=> 'required',
            'credit_card_percentage' => 'required | numeric',
            'wallet_price' => 'required | numeric',
           
        ]);

        $additionalPrice = HotelAdditionalPrice::find($id);
        $additionalPrice->additional_price = $request->additional_price;
        $additionalPrice->status = $request->status;
        $additionalPrice->credit_card_percentage = $request->credit_card_percentage;
        $additionalPrice->wallet_price = $request->wallet_price;
        $additionalPrice->save();

        Cache::forget('hotelserviceFee');
        return redirect()->route('markups.index')->with('success', 'Hotel Service Chargers Updated Successfully');
    }
}