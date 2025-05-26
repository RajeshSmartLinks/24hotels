<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PushNotification;
use App\Http\Controllers\Controller;

class PushNotificationsController extends Controller
{
    public function index()
    {
        $titles = [
            'title' => 'Notification',
            'subTitle' => 'Notification List',
        ];
        if (!auth()->user()->can('push-notification-view')) {
            return view('admin.abort',compact('titles'));
        }

        $deleteRouteName = "notifications.destroy";
        
        // dd(sendNotificationFcm('/topics/general_updates', 'test', "desc", "12"));
        $notifications = PushNotification::orderBy('id','desc')->get();

        return view('admin.push_notification.index', compact('titles', 'notifications' ,'deleteRouteName'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titles = [
            'title' => "Notifications",
            'subTitle' => "Add Notification",
        ];
        if (!auth()->user()->can('push-notification-add')) {
            return view('admin.abort',compact('titles'));
        }
        return view('admin.push_notification.create', compact('titles' ));
    }

    public function store(Request $req){
        if (!auth()->user()->can('push-notification-add')) {
            return view('admin.abort');
        }
        $this->validate($req, [
            'title_en' => 'required',
            'description_en' => 'required',
            'title_ar' => 'required',
            'description_ar' => 'required',
        ]);

        $comment = new PushNotification();
        $comment->title_en = $req->input('title_en');
        $comment->description_en = $req->input('description_en');
        $comment->title_ar = $req->input('title_ar');
        $comment->description_ar = $req->input('description_ar');
        $comment->save();
        // dd($comment);
        // $url = 'https://fcm.googleapis.com/fcm/send';
        // $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'id' => $req->id,'status'=>"done");
        // $notification = array('title' =>$req->title, 'text' => $req->body, 'image'=> $req->img, 'sound' => 'default', 'badge' => '1',);
        // $arrayToSend = array('to' => "/topics/all", 'notification' => $notification, 'data' => $dataArr, 'priority'=>'high');
        // $fields = json_encode ($arrayToSend);
        // $headers = array (
        //     'Authorization: key=' . "AAAAzWTNkJg:APA91bFLZC0sJHywUsob8NJQVIV0oFrwdGGI3tJabsu0URsLdAUkmYh1YvfYGB-gSymSSon0GIgOV4AnzrtlIBLFljAFsolwg_hSJ_htE-oBj-QBg8h6zBV-TCBAU0LpjIfsGu4gruyU",
        //     'Content-Type: application/json'
        // );
        // $ch = curl_init ();
        // curl_setopt ( $ch, CURLOPT_URL, $url );
        // curl_setopt ( $ch, CURLOPT_POST, true );
        // curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        // curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        // curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        // $result = curl_exec ( $ch );
        // //var_dump($result);
        // curl_close ( $ch );
        //sendNotificationFcm('/topics/general_updates', $req->title_en, $req->description_en, $comment->id);
        
        return redirect()->route('notifications.index')->with('success', 'Notifications Created successfully.');
    }

    public function sendNotification($id){
        if (!auth()->user()->can('send-push-notification')) {
            return view('admin.abort',compact('titles'));
        }

        $pushNotificaion = PushNotification::find($id);
        if(!empty($pushNotificaion)){
            $notificationRsp = sendNotification('general_updates', $pushNotificaion->title_en, $pushNotificaion->description_en);

            if($notificationRsp['status']){
                return redirect()->route('notifications.index')->with('success', 'Notification Sent Successfully');
            }else{
                return redirect()->route('notifications.index')->with('error', 'Something went wrong');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => 'Manage Push Notification', 'subTitle' => 'edit Push Notification'];

        if (!auth()->user()->can('push-notification-edit')) {
            return view('admin.abort', compact('titles'));
        }

        $editpushNotification = PushNotification::find($id);


        return view('admin.push_notification.edit', compact('titles', 'editpushNotification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('push-notification-edit')) {
            return view('admin.abort');
        }

        $this->validate($request, [
            'title_en' => 'required',
            'description_en' => 'required',
            'title_ar' => 'required',
            'description_ar' => 'required',
        ]);

        $pushNotificaion =  PushNotification::find($id);
        $pushNotificaion->title_en = $request->input('title_en');
        $pushNotificaion->description_en = $request->input('description_en');
        $pushNotificaion->title_ar = $request->input('title_ar');
        $pushNotificaion->description_ar = $request->input('description_ar');
        $pushNotificaion->save();

        return redirect()->route('notifications.index')->with('success', 'update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id ,Request $request)
    {
        if (!auth()->user()->can('push-notification-delete')) {
            return view('admin.abort');
        }

        $deleteId = $request->delete_id;
        $pushNotification = PushNotification::find($deleteId);

        if ($deleteId) {

            $pushNotification->delete();

            return redirect()->route('notifications.index')->with('success', 'Deleted Successfully');

        }
    }

}
