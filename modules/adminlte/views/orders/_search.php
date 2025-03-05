<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\adminlte\models\OrdersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'id' => 'admin-orders-filter',
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="d-flex gap-3 align-items-end flex-wrap">
        <div class="align-self-center mt-4">🔎</div>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'pick_up_id')->dropDownList($pickUps, ['prompt' => 'Выберите пункт выдачи']) ?>
        <?= $form->field($model, 'status_id')->dropDownList($statuses, ['prompt' => 'Выберите статус']) ?>
        <?= $form->field($model, 'date_delivery')->textInput(['type' => 'date']) ?>
        <div class="form-group d-flex gap-3">
            <?= Html::a('Сбросить', ['/admin-lte/orders'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
