<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/29/19
 */
declare(strict_types = 1);

namespace backend\services;

use backend\models\DepositAccount;
use backend\models\Transaction;
use backend\services\interfaces\ChargeServiceInterface;
use backend\services\interfaces\TransactionServiceInterface;
use yii\base\InvalidConfigException;

/**
 * Class CronService
 *
 * @package backend\services
 */
class CronService
{
    /** ChargeService */
    private $chargeService;

    /** TransactionService */
    private $transactionService;

    /**
     * CronService constructor.
     *
     * @throws InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct() {
        $this->chargeService = \Yii::createObject(ChargeServiceInterface::class);
        $this->transactionService = \Yii::createObject(TransactionServiceInterface::class);
    }

    /**
     * Runs cron
     */
    public function run(): void
    {
        $this->chargeInterest();
        if ((new \DateTime())->format('j') === 1) {
            $this->chargeFee();
        }
    }

    /**
     * Charges interest
     */
    private function chargeInterest(): void
    {
        $deposits = DepositAccount::getAllToChargeInterests();

        /** @var DepositAccount $deposit */
        foreach ($deposits as $deposit) {
            $amount = $this->chargeService->chargeInterest($deposit);
            if ($deposit->save()) {
                $this->transactionService->log(Transaction::TYPE_CHARGE_INTEREST, $amount, $deposit->id);
            }
        }
    }

    /**
     * Charges fee
     */
    private function chargeFee(): void
    {
        foreach (DepositAccount::find()->each(100) as $deposit) {
            $amount = $this->chargeService->chargeFee($deposit);
            if ($deposit->save()) {
                $this->transactionService->log(Transaction::TYPE_CHARGE_INTEREST, $amount, $deposit->id);
            }
        }
    }
}