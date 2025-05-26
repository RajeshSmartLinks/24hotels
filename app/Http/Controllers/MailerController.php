<?php

namespace App\Http\Controllers;

use App\Models\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailerController extends Controller
{
    public function index()
    {
      

    }

    public function sendMail()
    {
        $mails = Mailer::whereStatus('Actice')->whereIsCron(1)->whereIsFailed(0)->get(20);
        foreach ($mails as $key => $value) {
            if(!empty($value->attachment))
            {
                //attachments exists
                Mail::send($value->message,[], function($message)use($value) {
                    $message->to($value->email)
                            ->subject($value->subject)
                            ->attach(public_path($value->attachment), [
                                'as' => $value->attachment_name, 
                            ]);
                });
            }
            else{
                Mail::send($value->message,[], function($message) use($value) {
                    $message->to($value->email)
                            ->subject($value->subject);
                });
            }
          
        }
    }
}
