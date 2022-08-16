<?php
namespace App\Http\Controllers\Admin\Traits;
use Carbon\Carbon;
use App\Models\UserNotification;
trait  SendNotificationsTrait
{

    public function sendnotification($userid,$tripagentid,$tourguidid,$title,$body,$tokens,$message_content)
    {
        $SERVER_API_KEY = 'AAAA3vPFo-c:APA91bGpdsnBZPW1qv_W9OmxW7VnNzNy9GDgtBtpQvW5bZHWgEecGE1Hk_d5EXooH3-bOqAoMD9FRtgx6799Txm_hBvtqFoMiiVHv9zQ0ssRlXqnq-2GLDwyrRT32Jkqg2KmCj_pCQM5';
        $data = [
    //        //tokens >> array
         "registration_ids" => $tokens,
          //   "notification" => [
          //       "title" => $title,
          //       "body" => $body,
          //       "sound"=> "default" 
          //   ],
        ];
//         $dataString = json_encode($data);
//         $headers =
//          [
//              'Authorization: key=' . $SERVER_API_KEY,
//               'Content-Type: application/json',
//          ];
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    
//     $response = curl_exec($ch);

    //update in database
    $today=Carbon::now();
     UserNotification::create([
        'user_id'=>$userid,
        'tripagent_id'=>$tripagentid,
        'tourguide_id'=>$tourguidid,
        'title'=>$title,
        'body'=>$message_content,
        'expired_at'=>$today->addDays(30),
      ]);
          //update in database

     }
    }
    // public function store_notification($user_id,$title,$body)
    // {
       
    // }

