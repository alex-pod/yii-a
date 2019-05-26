<?php
/**
 * author: Alexander Podybailo
 * email: ninjootsu@gmail.com
 * date: 5/26/19
 */
declare(strict_types = 1);

namespace backend\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class BaseActiveRecord
 *
 * @package backend\models
 */
abstract class BaseActiveRecord extends ActiveRecord
{
    /**
     * Helps to get all ids as list.
     *
     * @return array
     */
    public static function getAllIds(): array
    {
        return ArrayHelper::getColumn(static::find()->select('id')->asArray()->all(), 'id');
    }
}