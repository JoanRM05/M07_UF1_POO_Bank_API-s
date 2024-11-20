<?php namespace ComBank\Support\Traits\ApiTrait;


trait PhoneApi{
    
    public function ValidatePhone(int $phone) : bool {
        
        $curl = curl_init();
        $api = "https://phonevalidation.abstractapi.com/v1/?api_key=6ea60303160641c98d55dbf7643ff02b&phone=".$phone;

        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false
        ));
        

        $response = curl_exec($curl);

        curl_close($curl);

        $obj = json_decode($response, true);

        if($obj['valid'] == false){

            return false;

        }

        return true;       
    }


}