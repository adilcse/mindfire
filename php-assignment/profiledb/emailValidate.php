<?php

class emailValidate{
    private $email;
    public function __construct($email){
        $this->email =urlencode($email);
      
    }
    public function validate(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.trumail.io/v2/lookups/json?email=".$this->email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));  
        $response = curl_exec($curl);
        $err = curl_error($curl);  
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
            return false;      
        } else {
            $arr = json_decode($response,true);
            return $arr;
        }
    }
   
}
?>
