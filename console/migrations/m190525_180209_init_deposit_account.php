<?php

use backend\models\Migration;

/**
 * Class m190525_180209_init_deposit_account
 */
class m190525_180209_init_deposit_account extends Migration
{
    private const TABLE_NAME_CUSTOMER = '{{%customer}}';
    private const TABLE_NAME_DEPOSIT_ACCOUNT = '{{%deposit_account}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            self::TABLE_NAME_DEPOSIT_ACCOUNT, [
            'id' => $this->primaryKey(),
            'avail_balance' => $this->decimal(10, 2)->notNull(),
            'interest_rate' => $this->smallInteger()->notNull(),
            'open_date' => $this->date()->notNull(),
            'open_day' => $this->tinyInteger()->notNull(),
            'status' => $this->tinyInteger(),
            'customer_id' => $this->integer()->notNull(),
        ],
            $this->tableOptions
        );


        $this->addForeignKey(
            '{{%fk_customer_deposit_account}}',
            self::TABLE_NAME_DEPOSIT_ACCOUNT,
            'customer_id',
            self::TABLE_NAME_CUSTOMER,
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk_customer_deposit_account}}', self::TABLE_NAME_DEPOSIT_ACCOUNT);
        $this->dropTable(self::TABLE_NAME_DEPOSIT_ACCOUNT);
    }
}
