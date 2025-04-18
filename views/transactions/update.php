<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Transactions $model */

$this->title = 'Редактировать сделку: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Сделки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transactions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'contacts' => $contacts,
        'contacts_checkbox_array' => $contacts_checkbox_array,
    ]) ?>

</div>
