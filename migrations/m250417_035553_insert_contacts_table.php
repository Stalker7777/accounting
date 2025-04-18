<?php

use yii\db\Migration;

class m250417_035553_insert_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $array_data = [
            ['id' => 1, 'uuid' => '5c1c27b8-1b40-11f0-bb1f-00155d292385', 'name' => 'Иван', 'surname' => 'Иванов'],
            ['id' => 2, 'uuid' => '68a18dd4-1b40-11f0-b29a-00155d292385', 'name' => 'Петр', 'surname' => 'Петров'],
            ['id' => 3, 'uuid' => '6e34c41e-1b40-11f0-b6b3-00155d292385', 'name' => 'Сидр', 'surname' => 'Сидоров'],
            ['id' => 4, 'uuid' => '7332d938-1b40-11f0-a7dd-00155d292385', 'name' => 'Василий'],
            ['id' => 5, 'uuid' => '0af6a290-1b41-11f0-b09c-00155d292385', 'name' => 'Светлана', 'surname' => 'Ястребова'],
        ];

        foreach ($array_data as $data) {
            $this->insert('{{%contacts}}', $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%contacts}}');
    }

}
