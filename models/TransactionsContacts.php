<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transactions_contacts".
 *
 * @property string $transactions_uuid
 * @property string $contacts_uuid
 *
 * @property Contacts $contactsUu
 * @property Transactions $transactionsUu
 */
class TransactionsContacts extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transactions_uuid', 'contacts_uuid'], 'required'],
            [['transactions_uuid', 'contacts_uuid'], 'string', 'max' => 36],
            [['transactions_uuid', 'contacts_uuid'], 'unique', 'targetAttribute' => ['transactions_uuid', 'contacts_uuid']],
            [['contacts_uuid'], 'exist', 'skipOnError' => true, 'targetClass' => Contacts::class, 'targetAttribute' => ['contacts_uuid' => 'uuid']],
            [['transactions_uuid'], 'exist', 'skipOnError' => true, 'targetClass' => Transactions::class, 'targetAttribute' => ['transactions_uuid' => 'uuid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transactions_uuid' => 'Transactions Uuid',
            'contacts_uuid' => 'Contacts Uuid',
        ];
    }

    /**
     * Gets query for [[ContactsUu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContactsUu()
    {
        return $this->hasOne(Contacts::class, ['uuid' => 'contacts_uuid']);
    }

    /**
     * Gets query for [[TransactionsUu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsUu()
    {
        return $this->hasOne(Transactions::class, ['uuid' => 'transactions_uuid']);
    }

}
