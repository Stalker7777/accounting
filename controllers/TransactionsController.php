<?php

namespace app\controllers;

use app\models\Contacts;
use app\models\Transactions;
use app\models\search\TransactionsSearch;
use app\models\TransactionsContacts;
use yii\rest\DeleteAction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * TransactionsController implements the CRUD actions for Transactions model.
 */
class TransactionsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Transactions models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TransactionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transactions model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $contacts = Contacts::find()
            ->innerJoinWith('transactionsContacts tc')
            ->where(['tc.transactions_uuid' => $model->uuid])
            ->all();

        return $this->render('view', [
            'model' => $model,
            'contacts' => $contacts,
        ]);
    }

    /**
     * Creates a new Transactions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Transactions();
        $contacts = Contacts::find()->all();
        $contacts_checkbox_array = [];

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $uuid = Yii::$app->uuid->uuid1();
                $model->uuid = $uuid->toString();

                if($model->save()) {

                    if($this->request->post('checkbox')) {
                        foreach ($this->request->post('checkbox') as $key => $value) {
                            if(count($value) > 1) {
                                $transaction_contacts = new TransactionsContacts();
                                $transaction_contacts->transactions_uuid = $model->uuid;
                                $transaction_contacts->contacts_uuid = $key;
                                $transaction_contacts->save();
                            }
                        }
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'contacts' => $contacts,
            'contacts_checkbox_array' => $contacts_checkbox_array,
        ]);
    }

    /**
     * Updates an existing Transactions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $contacts = Contacts::find()->all();
        $contacts_checkbox = Contacts::find()
            ->innerJoinWith('transactionsContacts tc')
            ->where(['tc.transactions_uuid' => $model->uuid])
            ->all();

        $contacts_checkbox_array = [];

        foreach ($contacts_checkbox as $item_contact) {
            $contacts_checkbox_array[] = $item_contact->uuid;
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if($model->save()) {

                if($this->request->post('checkbox')) {

                    TransactionsContacts::deleteAll(['transactions_uuid' => $model->uuid]);

                    foreach ($this->request->post('checkbox') as $key => $value) {
                        if(count($value) > 1) {
                            $transaction_contacts = new TransactionsContacts();
                            $transaction_contacts->transactions_uuid = $model->uuid;
                            $transaction_contacts->contacts_uuid = $key;
                            $transaction_contacts->save();
                        }
                    }
                }

            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'contacts' => $contacts,
            'contacts_checkbox_array' => $contacts_checkbox_array,
        ]);
    }

    /**
     * Deletes an existing Transactions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $transaction_contacts = TransactionsContacts::find()->where(['transactions_uuid' => $model->uuid])->all();

        foreach ($transaction_contacts as $transaction_contact) {
            $transaction_contact->delete();
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transactions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Transactions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transactions::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
