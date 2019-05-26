<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/26/19
 */
declare(strict_types = 1);

namespace backend\services;

use backend\models\Transaction;
use yii\base\BaseObject;
use backend\services\interfaces\ReporterInterface;

/**
 * Class Reporter
 *
 * @package backend\services
 */
class Reporter extends BaseObject implements ReporterInterface
{
    /**
     * Returns average balance of a deposit grouped by 3 age groups (18-25, 25-50 and above 50).
     *
     * @return array|false
     * @throws \yii\db\Exception
     */
    public function getAvgAmountDepositByAgeGroups()
    {
        return \Yii::$app->db->createCommand("
            SELECT 
                COUNT(@age := TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())) AS customers,
                AVG(IF(@age BETWEEN 18 and 24, avail_balance, NULL)) as '18 - 25',
                AVG(IF(@age BETWEEN 25 and 49, avail_balance, NULL)) as '25 - 50',
                AVG(IF(@age >= 50, avail_balance, NULL)) as '50+'
            FROM customer JOIN deposit_account ON customer.id = deposit_account.customer_id
        ")->queryOne();
    }

    /**
     * Returns revenue of a bank grouped by year and month.
     *
     * @return array|false
     * @throws \yii\db\Exception
     */
    public function getRevenueReportHistory()
    {
        return \Yii::$app->db->createCommand('
            SELECT 
                YEAR(FROM_UNIXTIME(created_at)) AS year,
                MONTH(FROM_UNIXTIME(created_at)) AS month,
                SUM(IF(type ='.Transaction::TYPE_CHARGE_INTEREST.', amount, NULL)) - 
                SUM(IF(type = '.Transaction::TYPE_CHARGE_MAINTENANCE_FEE.', amount, NULL)) AS revenue
            FROM transaction
            GROUP BY year, month;
        ')->queryAll();
    }
}