<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/26/19
 */
declare(strict_types = 1);

namespace backend\models;

use DateTime;
use yii\db\ActiveQuery;

/**
 * DepositAccount model
 *
 * @property integer $id
 * @property float   $avail_balance
 * @property int     $interest_rate
 * @property string  $open_date
 * @property int     $status
 * @property int     $customer_id
 */
class DepositAccount extends BaseActiveRecord
{
    public const STATUS_CLOSED = 0;
    public const STATUS_OPENED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'deposit_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['avail_balance', 'number'],
            ['open_date', 'date', 'format' => 'php:Y-m-d'],
            ['interest_rate', 'integer', 'min' => 0],
            ['status', 'in', 'range' => [self::STATUS_CLOSED, self::STATUS_OPENED]],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' =>
                ['customer_id' => 'id']],
        ];
    }

    /**
     * Get all deposits that should be charged for interests.
     *
     * @return array
     */
    public static function getAllToChargeInterests(): array
    {
        $todayDay = (new DateTime())->format('j');
        $lastDayOfMonth = (new DateTime())->format('t');

         if ($todayDay === $lastDayOfMonth) {
             return self::findBySql("SELECT * FROM ".self::tableName()." WHERE DAY(open_date) >= $todayDay")->all();
         }

         return self::findBySql("SELECT * FROM ".self::tableName()." WHERE DAY(open_date) = $todayDay")->all();
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTransaction(): ActiveQuery
    {
        return $this->hasMany(Transaction::class, ['deposit_account_id' => 'id']);
    }
}