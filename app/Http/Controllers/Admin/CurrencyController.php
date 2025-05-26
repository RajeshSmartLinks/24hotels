<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CurrencyController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = [
            'title' => __('admin.manage_currency'),
            'subTitle' => __('admin.currency_list'),
        ];
        if (!auth()->user()->can('currency-view')) {
            return view('admin.abort', compact('titles'));
        }
        $deleteRouteName = 'currency.destroy';

        $currencies = Currency::get();

        return view('admin.currency.index', compact('titles', 'currencies', 'deleteRouteName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titles = [
            'title' => __('admin.manage_currency'),
            'subTitle' => __('admin.currency_list'),
        ];
        if (!auth()->user()->can('currency-add')) {
            return view('admin.abort', compact('titles'));
        }

        return view('admin.currency.create', compact('titles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('currency-add')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            'conversion_rate' => 'required',
            'currency_code_en' => 'required',
            'currency_code_ar' => 'required'
        ]);

        $data = array();

        $data['from'] = "KWD";
        $data['to'] = $request->currency_code_en;
        $data['currency_code_en'] = $request->currency_code_en;
        $data['currency_code_ar'] = $request->currency_code_ar;
        $data['conversion_rate'] = $request->conversion_rate;

        Currency::updateOrCreate($data);
        Cache::forget('currencyDetails');
        Cache::forget('currencyList');
        
        return redirect()->route('currency.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'title' => __('admin.manage_currency'),
            'subTitle' => __('admin.currency_list'),
        ];
        if (!auth()->user()->can('currency-edit')) {
            return view('admin.abort', compact('titles'));
        }
        $editcurrency = Currency::find($id);

        return view('admin.currency.edit', compact('titles', 'editcurrency'));
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
        if (!auth()->user()->can('currency-edit')) {
            return view('admin.abort');
        }
        $this->validate($request, [
            //'from' => 'required',
            //'to' => 'required',
            'conversion_rate' => 'required',
            'currency_code_en' => 'required',
            'currency_code_ar' => 'required'
        ]);


        $currency = Currency::find($id);

        $currency->from = 'KWD';
        $currency->to = $request->currency_code_en;
        $currency->conversion_rate = $request->conversion_rate;
        $currency->currency_code_ar = $request->currency_code_ar;
        $currency->currency_code_en = $request->currency_code_en;

        
        $currency->save();
        Cache::forget('currencyDetails');
        Cache::forget('currencyList');
        return redirect()->route('currency.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('currency-delete')) {
            return view('admin.abort', compact('titles'));
        }

        $deleteId = $request->delete_id;
        $currency = Currency::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
         
          

            $currency->delete();

            return redirect()->route('currency.index')->with('success', 'Deleted Successfully');

        }
    }

    public function updateCurrencyByCron()
    {
        $currencies = Currency::get();
        $url = "https://v6.exchangerate-api.com/v6/".env('EXCHANGE_RATE_KEY')."/latest/KWD";
        $apiResponse = callApi($url, 'get');
        $response = $apiResponse->json();
        if($response['result'] == "success")
        {
            $exchangerates = $response['conversion_rates']; 
            foreach ($currencies as $currency) {
                Currency::where('id', $currency->id)->update(array('conversion_rate' => $exchangerates[$currency->to]));
            }
        }
        // else{
        //     //error response
        // }
        Cache::forget('currencyDetails');
        Cache::forget('currencyList');
        echo "currencys updated";
    }
}
