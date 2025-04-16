<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contents}}`.
 */
class m250416_072709_create_contents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contents}}', [
            'id' => $this->primaryKey(),
            'subtopics_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
        ]);

        $this->createIndex(
            'idx-contents-subtopics_id',
            '{{%contents}}',
            'subtopics_id'
        );

        $this->addForeignKey(
            'fk-contents-subtopics_id',
            '{{%contents}}',
            'subtopics_id',
            '{{%subtopics}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-contents-subtopics_id',
            '{{%contents}}'
        );

        $this->dropIndex(
            'idx-contents-subtopics_id',
            '{{%contents}}'
        );

        $this->dropTable('{{%contents}}');
    }
}
