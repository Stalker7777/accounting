<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subtopics}}`.
 */
class m250416_071402_create_subtopics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subtopics}}', [
            'id' => $this->primaryKey(),
            'topics_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
        ]);

        $this->createIndex(
            'idx-subtopics-topics_id',
            '{{%subtopics}}',
            'topics_id'
        );

        $this->addForeignKey(
            'fk-subtopics-topics_id',
            '{{%subtopics}}',
            'topics_id',
            '{{%topics}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-subtopics-topics_id',
            '{{%subtopics}}'
        );

        $this->dropIndex(
            'idx-subtopics-topics_id',
            '{{%subtopics}}'
        );

        $this->dropTable('{{%subtopics}}');
    }
}
