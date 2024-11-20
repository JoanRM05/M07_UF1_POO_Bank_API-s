<?php namespace ComBank\Support\Traits\ApiTrait;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait FraudApi{
    
    public function detectFraud(BankTransactionInterface $banktransaction) : bool {
        $curl = curl_init();
        $api = "https://67377b9faafa2ef22233fb28.mockapi.io/Fraud";

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

        $fraud = false;

        switch($banktransaction->getTransactionInfo()){

            case "DEPOSIT_TRANSACTION":

                foreach($obj as $objeto => $value){

                    if ($obj[$objeto]['Movement'] == "DEPOSIT_TRANSACTION"){

                        if($obj[$objeto]['Amount'] <= $banktransaction->getAmount()){

                            if($obj[$objeto]['Allowed'] == false){
                                $fraud = true;
                            }else {
                                $fraud = false;
                            }

                        }

                    }
                }

            break;

            case "WITHDRAW_TRANSACTION":

                foreach($obj as $objeto => $value){

                    if ($obj[$objeto]['Movement'] == "WITHDRAW_TRANSACTION"){

                        if($obj[$objeto]['Amount'] <= $banktransaction->getAmount()){

                            if($obj[$objeto]['Allowed'] == false){
                                $fraud = true;
                            }else {
                                $fraud = false;
                            }

                        }

                    }
                }

            break;

        }


        return $fraud;

        
    }

}