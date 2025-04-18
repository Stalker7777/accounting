<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property int|null $amount
 *
 * @property Contacts[] $contactsUus
 * @property TransactionsContacts[] $transactionsContacts
 */
class Transactions extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'default', 'value' => 0],
            [['name'], 'required'],
            [['amount'], 'integer'],
            [['uuid'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 50],
            [['uuid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'name' => 'Наименование',
            'amount' => 'Сумма',
        ];
    }

    /**
     * Gets query for [[ContactsUus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContactsUus()
    {
        return $this->hasMany(Contacts::class, ['uuid' => 'contacts_uuid'])->viaTable('transactions_contacts', ['transactions_uuid' => 'uuid']);
    }

    /**
     * Gets query for [[TransactionsContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsContacts()
    {
        return $this->hasMany(TransactionsContacts::class, ['transactions_uuid' => 'uuid']);
    }

}
