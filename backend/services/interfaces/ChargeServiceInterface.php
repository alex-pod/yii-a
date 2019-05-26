<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/26/19
 */

namespace backend\services\interfaces;

/**
 * Interface ChargeServiceInterface
 *
 * @package backend\services\interfaces
 */
interface ChargeServiceInterface
{
    public const MAINTENANCE_FEE_FIXED_MIN = 50;
    public const MAINTENANCE_FEE_FIXED_MAX = 5000;
}