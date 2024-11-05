<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{
    function __construct(float $amount){
        
        parent::validateAmount($amount);

        $this->amount = $amount;
        
    }

    public function applyTransaction(BackAccountInterface $BankAccount):float{

        $newBalance = $BankAccount->getBalance() + $this->getAmount();
        
        return $newBalance;

    }

    public function getTransactionInfo():string{

        return "DEPOSIT_TRANSACTION";
        
    }

    public function getAmount():float{

        return $this->amount;
    
    }

}
