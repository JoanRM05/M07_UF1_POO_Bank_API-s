<?php namespace ComBank\Bank;


class NationalBankAccount extends BankAccount{
    function __construct(float $balance = 0){
        
        parent::__construct($balance);

    }
}
