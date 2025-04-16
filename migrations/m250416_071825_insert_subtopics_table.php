<?php

use yii\db\Migration;

class m250416_071825_insert_subtopics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $array_data = [
            ['id' => 1, 'topics_id' => 1, 'name' => 'Подтема 1.1'],
            ['id' => 2, 'topics_id' => 1, 'name' => 'Подтема 1.2'],
            ['id' => 3, 'topics_id' => 1, 'name' => 'Подтема 1.3'],
            ['id' => 4, 'topics_id' => 1, 'name' => 'Подтема 1.4'],
            ['id' => 5, 'topics_id' => 1, 'name' => 'Подтема 1.5'],

            ['id' => 6, 'topics_id' => 2, 'name' => 'Подтема 2.1'],
            ['id' => 7, 'topics_id' => 2, 'name' => 'Подтема 2.2'],
            ['id' => 8, 'topics_id' => 2, 'name' => 'Подтема 2.3'],
            ['id' => 9, 'topics_id' => 2, 'name' => 'Подтема 2.4'],
            ['id' => 10, 'topics_id' => 2, 'name' => 'Подтема 2.5'],

            ['id' => 11, 'topics_id' => 3, 'name' => 'Подтема 3.1'],
            ['id' => 12, 'topics_id' => 3, 'name' => 'Подтема 3.2'],
            ['id' => 13, 'topics_id' => 3, 'name' => 'Подтема 3.3'],
            ['id' => 14, 'topics_id' => 3, 'name' => 'Подтема 3.4'],
            ['id' => 15, 'topics_id' => 3, 'name' => 'Подтема 3.5'],

            ['id' => 16, 'topics_id' => 4, 'name' => 'Подтема 4.1'],
            ['id' => 17, 'topics_id' => 4, 'name' => 'Подтема 4.2'],
            ['id' => 18, 'topics_id' => 4, 'name' => 'Подтема 4.3'],
            ['id' => 19, 'topics_id' => 4, 'name' => 'Подтема 4.4'],
            ['id' => 20, 'topics_id' => 4, 'name' => 'Подтема 4.5'],

            ['id' => 21, 'topics_id' => 5, 'name' => 'Подтема 5.1'],
            ['id' => 22, 'topics_id' => 5, 'name' => 'Подтема 5.2'],
            ['id' => 23, 'topics_id' => 5, 'name' => 'Подтема 5.3'],
            ['id' => 24, 'topics_id' => 5, 'name' => 'Подтема 5.4'],
            ['id' => 25, 'topics_id' => 5, 'name' => 'Подтема 5.5'],
        ];

        foreach ($array_data as $data) {
            $this->insert('{{%subtopics}}', $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%subtopics}}');
    }
}
