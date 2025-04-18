<?php

use yii\db\Migration;

class m250417_040527_insert_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $array_data = [
            ['id' => 1, 'uuid' => '85a4141e-1b41-11f0-9ba7-00155d292385', 'name' => 'Хотят люстру', 'amount' => 5000],
            ['id' => 2, 'uuid' => '8a96da88-1b41-11f0-95c4-00155d292385', 'name' => 'Хотят светильник', 'amount' => 6000],
            ['id' => 3, 'uuid' => '9077860a-1b41-11f0-8db9-00155d292385', 'name' => 'Хотят смеситель', 'amount' => 8000],
            ['id' => 4, 'uuid' => '968bc466-1b41-11f0-a025-00155d292385', 'name' => 'Пока думают'],
        ];

        foreach ($array_data as $data) {
            $this->insert('{{%transactions}}', $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%transactions}}');
    }

}
