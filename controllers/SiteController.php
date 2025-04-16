<?php

namespace app\controllers;

use app\models\Contents;
use app\models\Subtopics;
use app\models\Topics;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $topics = Topics::find()->all();
        $subtopics = Subtopics::find()->where(['topics_id' => 1])->all();
        $contents = Contents::find()->where(['subtopics_id' => 1])->one();

        return $this->render('index', [
            'topics' => $topics,
            'subtopics' => $subtopics,
            'contents' => $contents,
        ]);
    }

    public function actionGetSubtopics()
    {
        if(Yii::$app->request->isAjax) {
            if(Yii::$app->request->isPost) {
                if(Yii::$app->request->post('topic_id')) {
                    $topic_id = Yii::$app->request->post('topic_id');
                    $subtopics = Subtopics::find()->where(['topics_id' => $topic_id])->all();
                    $data = [];
                    foreach ($subtopics as $subtopic) {
                        $data[] = ['subtopics_id' => $subtopic->id, 'subtopics_name' => $subtopic->name];
                    }
                    return json_encode(['result' => true, 'data' => $data]);
                }
            }
        }
        return json_encode(['result' => false]);
    }

    public function actionGetContents()
    {
        if(Yii::$app->request->isAjax) {
            if(Yii::$app->request->isPost) {
                if(Yii::$app->request->post('subtopic_id')) {
                    $subtopic_id = Yii::$app->request->post('subtopic_id');
                    $contents = Contents::find()->where(['subtopics_id' => $subtopic_id])->one();
                    return json_encode(['result' => true, 'content' => $contents->content]);
                }
            }
        }
        return json_encode(['result' => false]);
    }
}
