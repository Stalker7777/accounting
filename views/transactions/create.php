<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Transactions $model */

$this->title = 'Создать сдлеку';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transactions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'contacts' => $contacts,
        'contacts_checkbox_array' => $contacts_checkbox_array,
    ]) ?>

</div>
