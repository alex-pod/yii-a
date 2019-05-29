<?php

use yii\db\Migration;

/**
 * Class m190529_211807_add_date_of_birth_key
 */
class m190529_211807_add_date_of_birth_key extends Migration
{
    private const TABLE_NAME_CUSTOMER = '{{%customer}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'date_of_birth',
            self::TABLE_NAME_CUSTOMER,
            'date_of_birth'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'date_of_birth',
            self::TABLE_NAME_CUSTOMER
        );
    }
}
