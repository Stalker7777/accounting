<?php

use yii\db\Migration;

class m250417_034832_insert_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $array_data = [
            ['id' => 1, 'guid' => 'menu_transactions', 'name' => 'Сделки'],
            ['id' => 2, 'guid' => 'menu_contacts', 'name' => 'Контакты'],
        ];

        foreach ($array_data as $data) {
            $this->insert('{{%menu}}', $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%menu}}');
    }

}
