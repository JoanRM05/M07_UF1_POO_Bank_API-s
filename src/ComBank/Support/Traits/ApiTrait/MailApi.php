<?php namespace ComBank\Support\Traits\ApiTrait;


trait MailApi{
    
    public function ValidateMail(String $email) : bool {
        $curl = curl_init();
        $api = "https://www.disify.com/api/email/".$email;

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

        if($obj['format'] == true && $obj['dns'] == true && $obj['disposable'] == false){

            return true;

        } 

        return false;

        
    }

}