<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string|null $surname
 *
 * @property TransactionsContacts[] $transactionsContacts
 * @property Transactions[] $transactionsUus
 */
class Contacts extends \yii\db\ActiveRecord
{
    public $checkbox;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['surname'], 'default', 'value' => null],
            [['name'], 'required'],
            [['uuid'], 'string', 'max' => 36],
            [['name', 'surname'], 'string', 'max' => 50],
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
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'checkbox' => '',
        ];
    }

    /**
     * Gets query for [[TransactionsContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsContacts()
    {
        return $this->hasMany(TransactionsContacts::class, ['contacts_uuid' => 'uuid']);
    }

    /**
     * Gets query for [[TransactionsUus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsUus()
    {
        return $this->hasMany(Transactions::class, ['uuid' => 'transactions_uuid'])->viaTable('transactions_contacts', ['contacts_uuid' => 'uuid']);
    }

}
