<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/26/19
 */

namespace backend\services\interfaces;

use backend\models\DepositAccount;

/**
 * Interface ChargeServiceInterface
 *
 * @package backend\services\interfaces
 */
interface ChargeServiceInterface
{
    public const MAINTENANCE_FEE_FIXED_MIN = 50;
    public const MAINTENANCE_FEE_FIXED_MAX = 5000;

    public const FEE_PERCENT_0_TO_1000 = 5;
    public const FEE_PERCENT_1000_TO_10000 = 6;
    public const FEE_PERCENT_ABOVE_10000 = 7;

    /**
     * Charge interests.
     *
     * @param DepositAccount $depositAccount
     */
    public function chargeInterest(DepositAccount $depositAccount);

    /**
     * Charge fee.
     *
     * @param DepositAccount $depositAccount
     *
     * @return float|int
     */
    public function chargeFee(DepositAccount $depositAccount);


}