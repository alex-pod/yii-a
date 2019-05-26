<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/26/19
 */
declare(strict_types = 1);

namespace backend\models;

use yii\db\ActiveQuery;

/**
 * Transaction model
 *
 * @property int   $id
 * @property float $amount
 * @property int   $type
 * @property int   $created_at
 * @property int   $updated_at
 * @property int   $deposit_account_id
 */
class Transaction extends BaseActiveRecord
{
    public const TYPE_CHARGE_INTEREST = 0;
    public const TYPE_CHARGE_MAINTENANCE_FEE = 1;

    public const TYPES = [
        self::TYPE_CHARGE_INTEREST, self::TYPE_CHARGE_MAINTENANCE_FEE,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['amount'], 'number'],
            [['deposit_account_id', 'type'], 'integer'],
            [['deposit_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepositAccount::class, 'targetAttribute' => ['deposit_account_id' => 'id']],
            [['amount', 'deposit_account_id', 'type'], 'required'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepositAccount(): ActiveQuery
    {
        return $this->hasOne(DepositAccount::class, ['id' => 'deposit_account_id']);
    }
}