<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Support\Traits\ApiTrait\FraudApi;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
    use FraudApi;    
    function __construct(float $amount){

        parent::validateAmount($amount);
        
        $this->amount = $amount;
    }

    public function applyTransaction(BackAccountInterface $BankAccount):float{
        
        $newBalance = $BankAccount->getBalance() - $this->getAmount();

        if(!$BankAccount->getOverdraft()->isGrantOverdraftFunds($newBalance)){
            if ($BankAccount->getOverdraft()->getOverdraftFundsAmount() == 0){
                throw new InvalidOverdraftFundsException("Insufficient balance to complete the withdrawal.");
            }
            
            throw new FailedTransactionException("Withdrawal exceeds overdraft limit.");
        } 

        if($this->detectFraud($this)){
            throw new \Exception("Fraud Detected. CAN NOT WITHDRAW this quantity.");
        }

        return $newBalance;
        
    }

    public function getTransactionInfo():string{

        return "WITHDRAW_TRANSACTION";
        
    }

    public function getAmount():float{

        return $this->amount;
    
    }
   
}
