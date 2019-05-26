<?php

use backend\models\Migration;

/**
 * Class m190525_205544_init_transaction
 */
class m190525_205544_init_transaction extends Migration
{
    private const TABLE_NAME_DEPOSIT_ACCOUNT = '{{%deposit_account}}';
    private const TABLE_NAME_TRANSACTION = '{{%transaction}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            self::TABLE_NAME_TRANSACTION,
            [
                'id' => $this->primaryKey(),
                'amount' => $this->decimal(10, 2),
                'type' => $this->tinyInteger()->unsigned()->notNull(),
                'deposit_account_id' => $this->integer()->notNull(),
                'created_at' => $this->integer()->unsigned()->notNull(),
                'updated_at' => $this->integer()->unsigned()->notNull(),
            ],
            $this->tableOptions
        );

        $this->addForeignKey(
            '{{%fk_deposit_account_transaction}}',
            self::TABLE_NAME_TRANSACTION,
            'deposit_account_id',
            self::TABLE_NAME_DEPOSIT_ACCOUNT,
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk_deposit_account_transaction}}', self::TABLE_NAME_TRANSACTION);

        $this->dropTable(self::TABLE_NAME_TRANSACTION);
    }
}
