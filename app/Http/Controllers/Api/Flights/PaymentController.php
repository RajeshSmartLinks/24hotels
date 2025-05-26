<?php

namespace App\Http\Controllers\Api\Flights;

use Illuminate\Http\Request;
use App\Models\FlightBooking;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MyFatoorahController;

class PaymentController extends Controller
{
    public function responseprocessing($booking_id)
    {
        $paymentId = request('paymentId');
        $flightbookingdetails = FlightBooking::find($booking_id);

        if($flightbookingdetails->booking_status == 'payment_initiated')
        {
            $myfatoorah = new MyFatoorahController();
            $invoicedata = $myfatoorah->callback($paymentId);
            if($invoicedata['IsSuccess'])
            {
                $flightbookingdetails->invoice_status = $invoicedata['Data']->InvoiceStatus;
                $flightbookingdetails->invoice_response = json_encode($invoicedata['Data']);
                $flightbookingdetails->payment_id = $paymentId;
                if($invoicedata['Data']->InvoiceStatus == 'Paid')
                {
                    $flightbookingdetails->booking_status = 'payment_successful';
                    $flightbookingdetails->payment_gateway = $invoicedata['Data']->focusTransaction->PaymentGateway;
                }
                elseif($invoicedata['Data']->InvoiceStatus == 'Expired'){
                    $flightbookingdetails->booking_status = 'payment_failure';
                }
                elseif($invoicedata['Data']->InvoiceStatus == 'Failed')
                {
                    $flightbookingdetails->booking_status = 'payment_exipre';
                }
                $flightbookingdetails->save();
    
                if($invoicedata['Data']->InvoiceStatus == 'Paid')
                {
                    header("Cache-Control: no-cache");
                    $data = [
                        "reference_no" => $flightbookingdetails->booking_ref_id,
                        "payment_id" => $paymentId,
                        "paid_amount" => $flightbookingdetails->total_amount,
                        "currency_code" => $flightbookingdetails->currency_code,
                        "status" => str_replace("_"," ",$flightbookingdetails->booking_status),
                    ];
                    return view('flutter_app.success', compact('data'));
                }
                else
                {
                    header("Cache-Control: no-cache");
                    $data = [
                        "reference_no" => $flightbookingdetails->booking_ref_id,
                        "payment_id" => $paymentId,
                        "paid_amount" => $flightbookingdetails->total_amount,
                        "currency_code" => $flightbookingdetails->currency_code,
                        "status" => str_replace("_"," ",$flightbookingdetails->booking_status),
                    ];
                    return view('flutter_app.failure', compact('data'));
                }
            }
        else{
            //error
            header("Cache-Control: no-cache");
            $data = [
                "reference_no" => $flightbookingdetails->booking_ref_id,
                "payment_id" => $paymentId,
                "paid_amount" => $flightbookingdetails->total_amount,
                "currency_code" => $flightbookingdetails->currency_code,
                "status" => str_replace("_"," ",$flightbookingdetails->booking_status),
            ];
            return view('flutter_app.failure', compact('data'));
        }
    }
    else{
        //error
    }
    }
}
