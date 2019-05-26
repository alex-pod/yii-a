<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/26/19
 */

namespace backend\services\interfaces;

/**
 * Interface ReporterInterface
 *
 * @package backend\services\interfaces
 */
interface ReporterInterface
{
    /**
     * Returns average balance of a deposit grouped by 3 age groups (18-25, 25-50 and above 50).
     *
     * @return array|false
     * @throws \yii\db\Exception
     */
    public function getAvgAmountDepositByAgeGroups();

    /**
     * Returns revenue of a bank grouped by year and month.
     *
     * @return array|false
     * @throws \yii\db\Exception
     */
    public function getRevenueReportHistory();
}