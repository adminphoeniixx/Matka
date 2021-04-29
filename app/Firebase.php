<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Firebase extends Model
{


	public function send($title,$body,$users){

		if ($users=="all") {
			$firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
		}else{
			$firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->where('id',[50,45]);
		}

		dd($firebaseToken);
		
          
        $SERVER_API_KEY = 'AAAAseE0pIo:APA91bG9ngDYme9z36wRAVsmfPF57d4A9Nzx5JYpXCOnrtdfD9RYwYih7WMzHmmiqH52MbU2PhGJHlJct16Qs3fUNbbk0KVkCrxeCajh3NiHG70kmBu4EoZG2sWF11QQYdw8xtz0DvqP';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $title,
                "body" => $body,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        dd($response);

	}
    
}
