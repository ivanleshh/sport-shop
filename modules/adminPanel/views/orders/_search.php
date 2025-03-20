<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\adminPanel\models\OrdersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => true
        ],
    ]); ?>

    <div class="d-flex gap-3 align-items-end flex-wrap">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span>🔎</span>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'pick_up_id')->dropDownList($pickUps, ['prompt' => 'Выберите пункт выдачи']) ?>
            <?= $form->field($model, 'status_id')->dropDownList($statuses, ['prompt' => 'Выберите статус']) ?>
            <?= $form->field($model, 'date_delivery')->textInput(['type' => 'date']) ?>
            <?= Html::a('Сбросить', ['/admin-panel/orders'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>