<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/26/19
 */
declare(strict_types = 1);

namespace backend\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * Customer model
 *
 * @property integer $id
 * @property string  $id_number
 * @property string  $first_name
 * @property string  $last_name
 * @property string  $gender
 * @property string  $date_of_birth
 * @property integer $created_at
 * @property integer $updated_at
 */
class Customer extends BaseActiveRecord
{
    public const GENDER_MALE = 'm';
    public const GENDER_FEMALE = 'f';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id_number', 'first_name', 'last_name'], 'string', 'max' => 255],
            ['date_of_birth', 'date', 'format' => 'php:Y-m-d'],
            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],
            [['id_number', 'first_name', 'last_name', 'gender', 'date_of_birth'], 'required'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDepositAccounts(): ActiveQuery
    {
        return $this->hasMany(DepositAccount::class, ['customer_id' => 'id']);
    }
}