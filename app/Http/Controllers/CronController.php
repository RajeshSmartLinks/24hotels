<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Models\FlightBooking;
use App\Models\Mailer;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller
{
    
    public function bookingRemainder(){
        header( 'Cache-Control: max-age=0,no-store');
        Log::info('This is some useful information.');
        $time = strtotime('-30 minutes');
        $time =  date('Y-m-d H:i:s', $time);
        $remainders = FlightBooking::where('is_remainder_send', '0')
                        ->whereNotNull('search_id')
                        ->whereIn('booking_status', ['booking_initiated', 'payment_initiated', 'payment_failure', 'payment_expire', 'travelport_failure'])
                        ->where(function($query) {
                            $query->whereDate('created_at', Carbon::today())
                                    ->orWhereDate('created_at', Carbon::yesterday());
                        })
                        ->where('created_at', '<=', $time) // Records within the last 30 minutes
                        ->limit(20)
                        ->get();
                                               
                        
        foreach ($remainders as $key => $value) {
            $flightBooking = FlightBooking::with('TravelersInfo','searchRequest')->find($value->id);
            //Cron picked
            $name = "";
            if(!empty($flightBooking->TravelersInfo)){
                $name = $flightBooking->TravelersInfo[0]->title ." ".$flightBooking->TravelersInfo[0]->first_name;
            }
            
            $flightBooking->is_remainder_send = '1';
            $flightBooking->save();

          
            $flightBooking->searchRequest->departure_date =  Carbon::parse($flightBooking->searchRequest->departure_date)->format('D, d M Y');
            $flightBooking->searchRequest->return_date =  !empty($flightBooking->searchRequest->return_date) ? Carbon::parse($flightBooking->searchRequest->return_date)->format('D, d M Y') : '';
            
            $subject = Ucfirst($flightBooking->searchRequest->flight_trip) . " Flight Ticket reminder from ". $flightBooking->searchRequest->flight_from ." to " .$flightBooking->searchRequest->flight_to;

            $mailrequest = Mail::send('front_end.email_templates.ticketRemainder',compact('flightBooking','name'), function($message) use($flightBooking , $subject) {
                $message->to($flightBooking->email)->subject($subject);
            });

            //if remainder send successfully
            $flightBooking->is_remainder_send = '2';
            $flightBooking->save();

            // if($mailrequest){
            //     //if remainder send successfully
            //     $flightBooking->is_remainder_send = '2';
            //     $flightBooking->save();
            // }else{
            //     //if remainder faulure 
            //     $flightBooking->is_remainder_send = '3';
            //     $flightBooking->save();
            // }  
        }
        echo " Remainders are sent successfully ";
    }

    /**
     * Send up to 10 pending emails from the mailers table on every request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function sendMails(Request $request)
    {
        if (!headers_sent()) {
            header('Cache-Control: max-age=0,no-store');
        }
        Log::info('CronController::sendMails execution started.');

        // Fetch up to 10 pending emails
        $pendingMails = Mailer::where('is_send', '0')
            ->orderBy('id', 'asc')
            ->limit(10)
            ->get();

        if ($pendingMails->isEmpty()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No pending emails to send.',
                    'sent_count' => 0,
                    'failed_count' => 0,
                ]);
            }
            echo "No pending emails to send.";
            return;
        }

        $sentCount = 0;
        $failedCount = 0;

        foreach ($pendingMails as $mail) {
            try {
                $recipientEmail = $mail->receiver_email;
                $recipientName = $mail->receiver_name;
                $subject = $mail->subject ?: 'Notification';
                $htmlContent = $mail->html_data;

                if (empty($recipientEmail) || empty($htmlContent)) {
                    Log::warning("CronController::sendMails: Skipping mailer ID {$mail->id} due to missing email or content.");
                    continue;
                }

                Mail::send([], [], function ($message) use ($recipientEmail, $recipientName, $subject, $htmlContent) {
                    if (!empty($recipientName)) {
                        $message->to($recipientEmail, $recipientName);
                    } else {
                        $message->to($recipientEmail);
                    }
                    $message->subject($subject)
                            ->setBody($htmlContent, 'text/html');
                });

                $mail->is_send = '1';
                $mail->sent_at = Carbon::now();
                $mail->save();

                $sentCount++;
            } catch (\Throwable $e) {
                $failedCount++;
                Log::error("CronController::sendMails: Error sending mailer ID {$mail->id}: " . $e->getMessage());
            }
        }

        $summary = "Mails processed: {$pendingMails->count()} (Sent: {$sentCount}, Failed: {$failedCount})";
        Log::info("CronController::sendMails finished. " . $summary);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => $summary,
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
            ]);
        }

        echo $summary;
    }
}
