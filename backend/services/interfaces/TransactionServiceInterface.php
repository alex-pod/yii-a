<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/29/19
 */

namespace backend\services\interfaces;

/**
 * Interface TransactionServiceInterface
 *
 * @package backend\services\interfaces
 */
interface TransactionServiceInterface
{
    /**
     * @param int   $type
     * @param float $amount
     * @param int   $depositAccountId
     *
     * @return bool
     */
    public function log(
        int $type,
        float $amount,
        int $depositAccountId
    ): bool;
}