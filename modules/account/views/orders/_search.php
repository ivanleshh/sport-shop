<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\account\models\OrdersSearch $model */
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

    <div class="row align-items-end">
        <div class="col-12 col-sm-6 col-lg-3"><?= $form->field($model, 'status_id')->dropDownList($statuses, ['prompt' => 'Выберите статус']) ?></div>
        <div class="col-12 col-sm-6 col-lg-3"><?= $form->field($model, 'pick_up_id')->dropDownList($pickUps, ['prompt' => 'Выберите пункт выдачи']) ?></div>
        <div class="col-6 col-lg-3"><?= $form->field($model, 'date_delivery')->textInput(['type' => 'date']) ?></div>
        <div class="col-6 col-lg-3"><?= Html::a('Сбросить', ['/personal/orders'], ['class' => 'btn btn-outline-secondary w-100']) ?></div>
    </div>

    <?php ActiveForm::end(); ?>
</div>