<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Transactions $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Сделки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="transactions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'uuid',
            'name',
            'amount',
        ],
    ]) ?>

    <?php foreach ($contacts as $contact) { ?>
        <div class="row">
            <div class="col-lg-2 offset-lg-2">
                <a href="<?= Url::toRoute(['contacts/view', 'id' => $contact->id]) ?>">
                    <?= $contact->name ?> <?= $contact->surname ?>
                </a>
            </div>
        </div>
    <?php } ?>

</div>
