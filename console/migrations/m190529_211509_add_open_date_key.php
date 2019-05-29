<?php

use yii\db\Migration;

/**
 * Class m190529_211509_add_open_date_key
 */
class m190529_211509_add_open_date_key extends Migration
{
    private const TABLE_NAME_DEPOSIT_ACCOUNT = '{{%deposit_account}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'open_date',
            self::TABLE_NAME_DEPOSIT_ACCOUNT,
            'open_date'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'open_date',
            self::TABLE_NAME_DEPOSIT_ACCOUNT
        );
    }
}
