<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-form">
    <?php Pjax::begin([
        'id' => 'form-delay-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'form-delay',
            'options' => [
                'data-pjax' => true,
            ]
        ]); ?>
            <?= $form->field($model_delay, 'delay_reason')->textarea(['rows' => 3]) ?>
            <?= $form->field($model_delay, 'new_date_delivery')->textInput(['type' => 'date', 'min' => date('Y-m-d', strtotime('+1 day'))]) ?>
            <div class="form-group d-flex gap-3 justify-content-end mt-3">
                <?= Html::a('Назад', '', [
                    'class' => 'btn btn-secondary btn-modal-close',
                    'data-pjax' => 0
                ]) ?>
                <?= Html::submitButton('Перенести доставку', ['class' => 'btn btn-danger']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>