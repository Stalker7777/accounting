<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contents".
 *
 * @property int $id
 * @property int $subtopics_id
 * @property string $content
 *
 * @property Subtopics $subtopics
 */
class Contents extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subtopics_id', 'content'], 'required'],
            [['subtopics_id'], 'integer'],
            [['content'], 'string'],
            [['subtopics_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subtopics::class, 'targetAttribute' => ['subtopics_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subtopics_id' => 'Subtopics ID',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[Subtopics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubtopics()
    {
        return $this->hasOne(Subtopics::class, ['id' => 'subtopics_id']);
    }

}
