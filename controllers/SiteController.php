<?php

namespace app\controllers;

use app\models\Contacts;
use app\models\Contents;
use app\models\Menu;
use app\models\Subtopics;
use app\models\Topics;
use app\models\Transactions;
use app\models\TransactionsContacts;
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
        $menu = Menu::find()->all();
        $transactions = Transactions::find()->all();
        $contacts = [];
        if(count($transactions) > 0) {
            $contacts = Contacts::find()
                ->innerJoinWith('transactionsContacts tc')
                ->where(['tc.transactions_uuid' => $transactions[0]->uuid])
                ->all();
        }

        return $this->render('index', [
            'menu' => $menu,
            'transactions' => $transactions,
            'contacts' => $contacts,
        ]);
    }

    /**
     * @return false|string
     */
    public function actionGetSubmenuLists()
    {
        if(Yii::$app->request->isAjax) {
            if(Yii::$app->request->isPost) {
                if(Yii::$app->request->post('menu_guid')) {
                    $menu_guid = Yii::$app->request->post('menu_guid');
                    if($menu_guid == 'menu_transactions') {
                        $transactions = Transactions::find()->all();
                        $data = [];
                        foreach ($transactions as $transaction) {
                            $data[] = ['id' => $transaction->id, 'uuid' => $transaction->uuid, 'name' => $transaction->name, 'amount' => $transaction->amount];
                        }
                        return json_encode(['result' => true, 'menu_guid' => $menu_guid, 'data' => $data]);
                    }
                    if($menu_guid == 'menu_contacts') {
                        $contacts = Contacts::find()->all();
                        $data = [];
                        foreach ($contacts as $contact) {
                            $data[] = ['id' => $contact->id, 'uuid' => $contact->uuid, 'name' => $contact->name, 'surname' => $contact->surname];
                        }
                        return json_encode(['result' => true, 'menu_guid' => $menu_guid, 'data' => $data]);
                    }
                }
            }
        }
        return json_encode(['result' => false]);
    }

    /**
     * @return false|string
     */
    public function actionGetContentTransaction()
    {
        if(Yii::$app->request->isAjax) {
            if (Yii::$app->request->isPost) {
                if (Yii::$app->request->post('transaction_uuid')) {
                    $transaction_uuid = Yii::$app->request->post('transaction_uuid');

                    $transaction_data = [];
                    $transactions = Transactions::find()->where(['uuid' => $transaction_uuid])->one();
                    if(isset($transactions->id)) {
                        $transaction_data = [
                            'id' => $transactions->id,
                            'name' => $transactions->name,
                            'amount' => $transactions->amount,
                        ];
                    }

                    $contacts_data = [];
                    $contacts = Contacts::find()
                        ->innerJoinWith('transactionsContacts tc')
                        ->where(['tc.transactions_uuid' => $transaction_uuid])
                        ->all();
                    foreach ($contacts as $contact) {
                        $contacts_data[] = [
                            'id' => $contact->id,
                            'name' => $contact->name,
                            'surname' => $contact->surname,
                        ];
                    }

                    return json_encode(['result' => true, 'transaction' => $transaction_data, 'contacts' => $contacts_data]);
                }
            }
        }
        return json_encode(['result' => false]);
    }

    /**
     * @return false|string
     */
    public function actionGetContentContact()
    {
        if(Yii::$app->request->isAjax) {
            if (Yii::$app->request->isPost) {
                if (Yii::$app->request->post('contact_uuid')) {
                    $contact_uuid = Yii::$app->request->post('contact_uuid');

                    $contact_data = [];
                    $contacts = Contacts::find()->where(['uuid' => $contact_uuid])->one();
                    if(isset($contacts->id)) {
                        $contact_data = [
                            'id' => $contacts->id,
                            'name' => $contacts->name,
                            'surname' => $contacts->surname,
                        ];
                    }

                    $transactions_data = [];
                    $transactions = Transactions::find()
                        ->innerJoinWith('transactionsContacts tc')
                        ->where(['tc.contacts_uuid' => $contact_uuid])
                        ->all();
                    foreach ($transactions as $transaction) {
                        $transactions_data[] = [
                            'id' => $transaction->id,
                            'name' => $transaction->name,
                        ];
                    }

                    return json_encode(['result' => true, 'contact' => $contact_data, 'transactions' => $transactions_data]);
                }
            }
        }
        return json_encode(['result' => false]);
    }

    /**
     * @return string
     */
    public function actionIndexFirst()
    {
        $topics = Topics::find()->all();
        $subtopics = Subtopics::find()->where(['topics_id' => 1])->all();
        $contents = Contents::find()->where(['subtopics_id' => 1])->one();

        return $this->render('index-first', [
            'topics' => $topics,
            'subtopics' => $subtopics,
            'contents' => $contents,
        ]);
    }

    /**
     * @return false|string
     */
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

    /**
     * @return false|string
     */
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
