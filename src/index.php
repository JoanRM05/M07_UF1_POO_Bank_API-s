<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Person\person;
use ComBank\Bank\BankAccount;
use ComBank\Bank\InternationalBankAccount;
use ComBank\Bank\NationalBankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;

require_once 'bootstrap.php';


//---[Bank account 1]---/
// create a new account1 with balance 400
pl('--------- [Start testing bank account #1, No overdraft] --------');
try {
    // show balance account
    $bankAccount1 = new BankAccount(400);
    
    pl("My balance: " . $bankAccount1->getBalance());
    // close account
    $bankAccount1->closeAccount();
    pl("My account is now closed.");
    // reopen account
    $bankAccount1->reopenAccount();
    pl("My account is now reopened.");
    
    // deposit +150 
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());

    $bankAccount1->transaction(new DepositTransaction(150));
    
    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());

    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());

    $bankAccount1->transaction(new WithdrawTransaction(25));

    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());

    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    
    $bankAccount1->transaction(new WithdrawTransaction(600));

} catch (ZeroAmountException $e) {
    pe($e->getMessage());
} catch (BankAccountException $e) {
    pe($e->getMessage());
} catch (InvalidOverdraftFundsException | FailedTransactionException $e) {
    pe('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());

$bankAccount1->closeAccount();
pl("My account is now closed");


//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    
    $bankAccount2 = new BankAccount(200);
    $bankAccount2->applyOverdraft(new SilverOverdraft());
    // show balance account
    pl("My balance: " . $bankAccount2->getBalance());
    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new DepositTransaction(100));
    
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new WithdrawTransaction(300));
   
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction deposit (-50) with current balance ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new WithdrawTransaction(50));
    
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new WithdrawTransaction(120));
    
} catch (FailedTransactionException $e) {
    pe('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());

    $bankAccount2->transaction(new WithdrawTransaction(20));
    
} catch (FailedTransactionException $e) {
    pe('Error transaction: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());

try {
    
    $bankAccount2->closeAccount();
    pl("My account is now closed.");

    $bankAccount2->closeAccount();
    
} catch (BankAccountException $e) {
    pe('Error: ' . $e->getMessage());
}


pl('--------- [Start testing national account (No conversion)] --------');

$bankAccount3 = new NationalBankAccount(500);

pl('My balance: ' . $bankAccount3 -> getBalance() . ' € ('.$bankAccount3 -> getCurrency().')' );

pl('--------- [Start testing international account (Dollar conversion)] --------');

$bankAccount4 = new InternationalBankAccount(300);

pl('My balance: ' . $bankAccount4 -> getBalance() . ' € ('.$bankAccount3 -> getCurrency().')');

pl('Converting balance to Dollars (Rate 1 EUR = ' . $bankAccount4 ->getRatesUSD() . ' $)');

pl('Converted Balance: ' . $bankAccount4 -> getConvertedBalance() . ' $ ('.$bankAccount4 -> getConvertedCurrency().')');

try{

    pl('--------- [Start testing national account] --------');

    pl('Validating email: pepito@gmail.com');

    $persona1 = new Person("Julian", 1, "pepito@gmail.com");

    pl('Email is valid');

    $bankAccount3->setPerson($persona1);



    pl('--------- [Start testing international account] --------');

    pl('Validating email: 1234@gamma.com');

    $persona2 = new Person("Pepe", 2, "1234@gamma.com");

    $bankAccount4->setPerson($persona2);

}catch (Exception $e){
    pe('Error: ' . $e->getMessage());
}


try{
    pl('--------- [Start testing Deposit (No Fraud)] --------');

    $bankAccount5 = new BankAccount(50000);

    pl("My balance: " . $bankAccount5->getBalance());

    pl('Doing transaction deposit (+19999) with current balance ' . $bankAccount5->getBalance());

    $bankAccount5->transaction(new DepositTransaction(19999));
    
    pl('My new balance after deposit (+19999) : ' . $bankAccount5->getBalance());



    pl('--------- [Start testing Deposit (Fraud)] --------');

    $bankAccount6 = new BankAccount(25000);

    pl("My balance: " . $bankAccount6->getBalance());

    pl('Doing transaction deposit (+20000) with current balance ' . $bankAccount6->getBalance());

    $bankAccount6->transaction(new DepositTransaction(20000));
    
    pl('My new balance after deposit (+20000) : ' . $bankAccount6->getBalance());

}catch(Exception $e){
    pe('Error: ' . $e->getMessage());
}


try{
    pl('--------- [Start testing Withdraw (No Fraud)] --------');

    $bankAccount7 = new BankAccount(13000);

    pl("My balance: " . $bankAccount7->getBalance());

    pl('Doing transaction deposit (-4999) with current balance ' . $bankAccount7->getBalance());

    $bankAccount7->transaction(new WithdrawTransaction(4999));
    
    pl('My new balance after deposit (-4999) : ' . $bankAccount7->getBalance());



    pl('--------- [Start testing Withdraw (Fraud)] --------');

    $bankAccount8 = new BankAccount(10000);

    pl("My balance: " . $bankAccount7->getBalance());

    pl('Doing transaction deposit (-5000) with current balance ' . $bankAccount8->getBalance());

    $bankAccount8->transaction(new WithdrawTransaction(5000));
    
    pl('My new balance after deposit (-5000) : ' . $bankAccount8->getBalance());


}catch(Exception $e){
    pe('Error: ' . $e->getMessage());
}


try{

    pl('--------- [Start testing Phone Number (Valid)] --------');

    pl('Validating phone number: +34 627 22 35 70');

    $persona3 = new Person("Julian", 1, "pepito@gmail.com", 34627223570);

    pl('Phone Number is valid');

    $bankAccount7->setPerson($persona3);

    sleep(2);

    pl('--------- [Start testing Phone Number (No Valid)] --------');

    pl('Validating phone number: +34 627 00 00 561');

    $persona4 = new Person("Pepe", 2, "1234@gama.com", 346270000561);

    $bankAccount8->setPerson($persona4);

}catch (Exception $e){
    pe('Error: ' . $e->getMessage());
}

