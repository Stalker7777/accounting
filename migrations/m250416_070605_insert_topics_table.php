<?php

use yii\db\Migration;

class m250416_070605_insert_topics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $array_data = [
            ['id' => 1, 'name' => 'Тема 1'],
            ['id' => 2, 'name' => 'Тема 2'],
            ['id' => 3, 'name' => 'Тема 3'],
            ['id' => 4, 'name' => 'Тема 4'],
            ['id' => 5, 'name' => 'Тема 5'],
        ];

        foreach ($array_data as $data) {
            $this->insert('{{%topics}}', $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%topics}}');
    }
}
