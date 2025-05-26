<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">
    <?php Pjax::begin([
        'id' => 'form-personal-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>
        <?php $form = ActiveForm::begin([
            'id' => 'form-personal',
            'options' => [
                'data-pjax' => true,
            ]
        ]); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'check')->checkbox() ?>
        <?= $form->field($model, 'password', ['options' => [
            'class' => 'collapse'
        ]])->passwordInput(['maxlength' => true, 'value' => '']) ?>
        <?= $form->field($model, 'password_repeat', ['options' => [
            'class' => 'collapse'
        ]])->passwordInput(['maxlength' => true, 'value' => '']) ?>
        <div class="form-group d-flex gap-3 justify-content-end mt-3">
            <?= Html::a('Закрыть', '', ['class' => 'btn btn-secondary btn-modal-close', 'data-pjax' => 0]) ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>
<?= $this->registerJsFile('/js/change-password.js', ['depends' => JqueryAsset::class]); ?>
