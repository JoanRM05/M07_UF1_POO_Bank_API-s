<?php namespace ComBank\Bank;

use ComBank\Support\Traits\ApiTraits\ConversionApi;
use PhpParser\Node\Expr\Cast\String_;

class InternationalBankAccount extends BankAccount {

    function __construct(float $balance = 0){  

        parent::__construct($balance);
    
    }

    public function getConvertedBalance():float{

        $BalanceConverted = $this->ConvertCurrencyUSD(self::getBalance());

        return $BalanceConverted;
    }

    
    public function getRatesUSD(): float{

        $RateUSD = $this->ConvertCurrencyUSD(1);

        return $RateUSD;

    } 

    public function getConvertedCurrency():string{

        return 'USD';

    }



}