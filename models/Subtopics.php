<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subtopics".
 *
 * @property int $id
 * @property int $topics_id
 * @property string $name
 *
 * @property Contents[] $contents
 * @property Topics $topics
 */
class Subtopics extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subtopics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topics_id', 'name'], 'required'],
            [['topics_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['topics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topics::class, 'targetAttribute' => ['topics_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topics_id' => 'Topics ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Contents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Contents::class, ['subtopics_id' => 'id']);
    }

    /**
     * Gets query for [[Topics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasOne(Topics::class, ['id' => 'topics_id']);
    }

}
