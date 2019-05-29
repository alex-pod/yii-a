<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/29/19
 */

namespace backend\services\interfaces;

/**
 * Interface CronServiceInterface
 *
 * @package backend\services\interfaces
 */
interface CronServiceInterface
{
    /**
     * Runs cron
     */
    public function run(): void;
}