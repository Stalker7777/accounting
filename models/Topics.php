<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "topics".
 *
 * @property int $id
 * @property string $name
 *
 * @property Subtopics[] $subtopics
 */
class Topics extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'topics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Subtopics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubtopics()
    {
        return $this->hasMany(Subtopics::class, ['topics_id' => 'id']);
    }

}
