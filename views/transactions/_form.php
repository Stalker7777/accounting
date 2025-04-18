<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Transactions $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transactions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uuid')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <div class="transactions-form-contacts">

        <?php foreach ($contacts as $contact) { ?>

            <div class="row">
                <div class="col-lg-1 offset-lg-2">
                    <?= $form->field($contact, 'checkbox')
                        ->checkbox(['name' => 'checkbox[' . $contact->uuid . '][]', 'checked ' => in_array($contact->uuid, $contacts_checkbox_array) ? true : false]) ?>
                </div>
                <div class="col-lg-5">
                    <?= $contact->name ?> <?= $contact->surname ?>
                </div>
            </div>

        <?php } ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
