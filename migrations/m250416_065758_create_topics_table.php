<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%topics}}`.
 */
class m250416_065758_create_topics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%topics}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%topics}}');
    }
}
