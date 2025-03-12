<?php

use yii\bootstrap5\Html;
use yii\web\JqueryAsset;
use yii\bootstrap5\ActiveForm;

use function PHPSTORM_META\map;

/** @var yii\web\View $this */
/** @var app\models\Cart $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-order',
    ]); ?>
    <div class="d-flex gap-3">
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="d-flex gap-3">
        <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7(999)-999-99-99',
        ]) ?>
        <?= $form->field($model, 'type_pay_id')->dropDownList($typePays, ['prompt' => 'Выберите тип оплаты']) ?>
    </div>
    <div class="pickup">
        <?= $form->field($model, 'pick_up_id')->dropDownList($pickUps, ['prompt' => 'Выберите пункты выдачи']) ?>
    </div>
    <?= $form->field($model, 'check')->checkbox() ?>
    <div class="delivery-fields collapse">
        <?= $form->field($model, 'address')->textarea(['rows' => 2]) ?>
        <div class="date-time-delivery d-flex gap-3">
            <?= $form->field($model, 'date_delivery')->textInput(['type' => 'date', 'min' => date('Y-m-d')]) ?>
            <?= $form->field($model, 'time_delivery')->textInput(['type' => 'time', 'min' => '09:00', 'max' => '21:00']) ?>
        </div>
        <?= $form->field($model, 'comment')->textarea(['rows' => 2]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?= $this->registerJsFile('/js/order-create.js', ['depends' => JqueryAsset::class]); ?>
