<?php

use yii\db\Migration;

class m250417_042911_insert_transactions_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $array_data = [
            /* transactions id = 1 */
            ['transactions_uuid' => '85a4141e-1b41-11f0-9ba7-00155d292385', 'contacts_uuid' => '5c1c27b8-1b40-11f0-bb1f-00155d292385'],
            ['transactions_uuid' => '85a4141e-1b41-11f0-9ba7-00155d292385', 'contacts_uuid' => '68a18dd4-1b40-11f0-b29a-00155d292385'],
            ['transactions_uuid' => '85a4141e-1b41-11f0-9ba7-00155d292385', 'contacts_uuid' => '6e34c41e-1b40-11f0-b6b3-00155d292385'],

            /* transactions id = 2 */
            ['transactions_uuid' => '8a96da88-1b41-11f0-95c4-00155d292385', 'contacts_uuid' => '5c1c27b8-1b40-11f0-bb1f-00155d292385'],
            ['transactions_uuid' => '8a96da88-1b41-11f0-95c4-00155d292385', 'contacts_uuid' => '68a18dd4-1b40-11f0-b29a-00155d292385'],
            ['transactions_uuid' => '8a96da88-1b41-11f0-95c4-00155d292385', 'contacts_uuid' => '6e34c41e-1b40-11f0-b6b3-00155d292385'],
        ];

        foreach ($array_data as $data) {
            $this->insert('{{%transactions_contacts}}', $data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%transactions_contacts}}');
    }

}
