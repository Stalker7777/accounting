<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transactions}}`.
 */
class m250417_040104_create_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transactions}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(36)->notNull()->unique(),
            'name' => $this->string(50)->notNull(),
            'amount' => $this->integer()->null()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transactions}}');
    }
}
