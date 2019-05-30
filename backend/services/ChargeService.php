<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/29/19
 */
declare(strict_types = 1);

namespace backend\services;

use backend\models\DepositAccount;
use backend\services\interfaces\ChargeServiceInterface;

/**
 * Class ChargeService
 *
 * @package backend\services
 */
class ChargeService implements ChargeServiceInterface
{
    /**
     * Charge interests.
     *
     * @param DepositAccount $depositAccount
     *
     * @return DepositAccount
     */
    public function chargeInterest(DepositAccount $depositAccount): DepositAccount
    {
        $interest = $depositAccount->avail_balance * ($depositAccount->interest_rate / 12);
        $depositAccount->avail_balance += $interest;

        return $depositAccount;
    }

    /**
     * Charge fee.
     *
     * @param DepositAccount $depositAccount
     *
     * @return DepositAccount
     */
    public function chargeFee(DepositAccount $depositAccount): DepositAccount
    {
        $availableBalance = $depositAccount->avail_balance;
        $fee = 0;

        if ($availableBalance > 0 && $availableBalance < 1000) {
            $fee = $availableBalance * self::FEE_PERCENT_0_TO_1000;
            $fee = $this->calculatePartialFee($depositAccount->open_date, $fee);
            if ($fee < self::MAINTENANCE_FEE_FIXED_MIN) {
                $fee = self::MAINTENANCE_FEE_FIXED_MIN;
            }
        }

        if ($availableBalance >= 1000 && $availableBalance < 10000) {
            $fee = $availableBalance * self::FEE_PERCENT_1000_TO_10000;
        }

        if ($availableBalance >= 10000) {
            $fee = $availableBalance * self::FEE_PERCENT_ABOVE_10000;
            $fee = $this->calculatePartialFee($depositAccount->open_date, $fee);
            if ($fee > self::MAINTENANCE_FEE_FIXED_MAX) {
                $fee = self::MAINTENANCE_FEE_FIXED_MAX;
            }
        }

        $depositAccount->avail_balance = $availableBalance - $fee;

        return $depositAccount;
    }

    /**
     * Calculates partial fee.
     *
     * @param string $openDate
     * @param float  $fee
     *
     * @return float
     */
    private function calculatePartialFee(string $openDate, float $fee): float
    {
        $openDatetime = new \DateTime($openDate);
        $currentDatetime = new \DateTime();

        if ($openDatetime->format('j') !== 1 &&
            $currentDatetime->format('n') - $openDatetime->format('n') === 1) {
            $daysInMonth = date('t', strtotime($openDate));
            $daysToBeCharged = $daysInMonth - $openDatetime->format('j') + 1;

            return ($fee / $daysInMonth) * $daysToBeCharged;
        }

        return (float)$fee;
    }
}