<?php namespace ComBank\Support\Traits;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 2:35 PM
 */

use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;

use function PHPUnit\Framework\throwException;

trait AmountValidationTrait
{
    /**
     * @param    $amount
     * @throws InvalidArgsException
     * @throws ZeroAmountException
     */
    public function validateAmount(float $amount):void
    {
        if(!is_numeric($amount)){
            throw new InvalidArgsException("Invalid amount value");
        }
        if($amount <= 0){
            throw new ZeroAmountException("Invalid amount value.");
        }
    }
}
