<?php

use app\models\Brand;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Brand $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="brand-form">

    <?php Pjax::begin([
        'id' => 'form-brand-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-brand',
        'options' => [
            'data-pjax' => true
        ]
    ]); ?>

    <div id="brand-uploaded-image" class="text-center"></div>

    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <?= $form->field($model, 'title')->textInput() ?>

    <div class="form-group d-flex justify-content-end gap-3">
        <?= Html::button('Закрыть', ['class' => 'btn btn-secondary btn-modal-close']) ?>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

</div>