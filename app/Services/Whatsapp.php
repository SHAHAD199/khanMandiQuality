<?php 

namespace App\Services;

class Whatsapp {
    
    public function send($phone, $body) {
  
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance13747/messages/chat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => 'token=r4a960xuyr00ag18&to=+964'.$phone.'&body='.$body.'&priority=1&referenceId=',
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded"
        ),
      ));
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      
      curl_close($curl);
      //  curl_getinfo($curl);  
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        return $response;
      }
       }
      
}