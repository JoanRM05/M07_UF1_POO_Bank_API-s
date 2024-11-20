<?php namespace ComBank\Person;

use ComBank\Support\Traits;
use ComBank\Support\Traits\ApiTrait\MailApi;
use ComBank\Support\Traits\ApiTrait\PhoneApi;

class Person {

    use MailApi, PhoneApi;

    private $name;
    private $IdCard;
    private $email;
    private $phone;

    function __construct(String $name, Int $idcard, String $email, Int $phone = null){
        
        $this->name = $name;
        $this->IdCard = $idcard;

        if (!$this->ValidateMail($email)){
            throw new \Exception("Invalid email address: ".$email);
        }

        $this->email = $email;

        if($phone != null && !$this->ValidatePhone($phone)){
            throw new \Exception("Invalid phone number: ".$phone);
        }

        $this->phone = $phone;

    }

}
