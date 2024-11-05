<?php namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use Error;

class BankAccount implements BackAccountInterface
{   
    use AmountValidationTrait;
    private $balance;
    private $status;
    private OverdraftInterface $overdraft;


    public function __construct(float $balance = 0.0){
        
        $this->validateAmount($balance);
        $this->balance = $balance;
        $this->status = true;
        $this->overdraft = new NoOverdraft(); 

    }

    public function transaction(BankTransactionInterface $BankTransaction): void{
        
        if ($this->status == true){
            
            $newBalance = $BankTransaction->applyTransaction($this);
            
            $this->setBalance($newBalance);
            
        }else {
            throw new BankAccountException("My account is closed");
        }
        
    }

    public function openAccount(): bool{
        
        if($this->status == false){
            return $this->status = false;
        }

        return $this->status = true;
        
        
    }

    public function reopenAccount(): void{
        if  ($this->status == true) {

            throw new BankAccountException("Account is already open");
            
        }

        $this->status = true;
        
    }

    public function closeAccount(): void{
        if($this->status == false){

            throw new BankAccountException("Account is already closed");
        
        }

        $this->status = false;
        
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getOverdraft(): OverdraftInterface
    {
        return $this->overdraft;
    }

    public function applyOverdraft(OverdraftInterface $overdraft): void{

        $this->overdraft = $overdraft;

    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance; 
    }
}
