<?php namespace ComBank\Support\Traits\ApiTrait;

trait ConversionApi {

    public function ConvertCurrencyUSD(float $Balance) : float {
        
        $curl = curl_init();
        $api = "https://api.fxratesapi.com/latest?currencies=USD&base=EUR&places=2&amount=".$Balance;

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

        return $obj['rates']['USD'];

    }  

}

