<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transactions_contacts}}`.
 */
class m250417_040906_create_transactions_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transactions_contacts}}', [
            'transactions_uuid' => $this->string(36)->notNull(),
            'contacts_uuid' => $this->string(36)->notNull(),
        ]);

        $this->addPrimaryKey('pk_transactions_contacts_uuid', '{{%transactions_contacts}}', ['transactions_uuid', 'contacts_uuid']);

        $this->createIndex(
            'idx-transactions_contacts-transactions_uuid',
            '{{%transactions_contacts}}',
            'transactions_uuid'
        );

        $this->addForeignKey(
            'fk-transactions_contacts-transactions_uuid',
            '{{%transactions_contacts}}',
            'transactions_uuid',
            '{{%transactions}}',
            'uuid',
        );

        $this->createIndex(
            'idx-transactions_contacts-contacts_uuid',
            '{{%transactions_contacts}}',
            'contacts_uuid'
        );

        $this->addForeignKey(
            'fk-transactions_contacts-contacts_uuid',
            '{{%transactions_contacts}}',
            'contacts_uuid',
            '{{%contacts}}',
            'uuid',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-transactions_contacts-contacts_uuid',
            '{{%transactions_contacts}}'
        );

        $this->dropIndex(
            'idx-transactions_contacts-contacts_uuid',
            '{{%transactions_contacts}}'
        );

        $this->dropForeignKey(
            'fk-transactions_contacts-transactions_uuid',
            '{{%transactions_contacts}}'
        );

        $this->dropIndex(
            'idx-transactions_contacts-transactions_uuid',
            '{{%transactions_contacts}}'
        );

        $this->dropTable('{{%transactions_contacts}}');
    }
}
