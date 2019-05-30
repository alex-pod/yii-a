<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/29/19
 */
declare(strict_types = 1);

namespace backend\services;

use backend\models\Transaction;
use backend\services\interfaces\TransactionServiceInterface;

/**
 * Class TransactionService
 *
 * @package backend\services
 */
class TransactionService implements TransactionServiceInterface
{
    /**
     * @param int   $type
     * @param float $amount
     * @param int   $depositAccountId
     */
    public function log(
        int $type,
        float $amount,
        int $depositAccountId
    ): void {
        $txn = new Transaction();

        $txn->type = $type;
        $txn->amount = $amount;
        $txn->deposit_account_id = $depositAccountId;
        $txn->save();
    }
}