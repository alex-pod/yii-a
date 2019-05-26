<?php

use backend\models\Migration;

/**
 * Class m190525_142557_init_customer
 */
class m190525_142557_init_customer extends Migration
{
    private const TABLE_NAME_CUSTOMER = '{{%customer}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            self::TABLE_NAME_CUSTOMER, [
            'id' => $this->primaryKey(),
            'id_number' => $this->string()->notNull()->unique(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'gender' => $this->char(1),
            'date_of_birth' => $this->date(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
        ],
            $this->tableOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME_CUSTOMER);
    }
}
