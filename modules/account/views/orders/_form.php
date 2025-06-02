<?php

use yii\bootstrap5\Html;
use yii\web\JqueryAsset;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

use function PHPSTORM_META\map;

/** @var yii\web\View $this */
/** @var app\models\Cart $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">
    <?php Pjax::begin([
        'id' => 'order-form-pjax',
        'enablePushState' => false,
        'timeout' => 5000
    ]); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-order',
    ]); ?>

    <div class="row">
        <div class="col-12 col-sm-6">
            <?= $form->field($model, 'name')->textInput() ?>
        </div>
        <div class="col-12 col-sm-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-12 col-sm-6">
            <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
                'mask' => '+7(999)-999-99-99',
            ]) ?>
        </div>
        <div class="col-12 col-sm-6">
            <?= $form->field($model, 'type_pay_id')->dropDownList($typePays, ['prompt' => 'Выберите тип оплаты']) ?>
        </div>
        <div class="pickup">
            <?= $form->field($model, 'pick_up_id')->dropDownList($pickUps, ['prompt' => 'Выберите пункты выдачи']) ?>
        </div>
        <div class="col-12 col-sm-6">
            <?= $form->field($model, 'check')->checkbox() ?>
        </div>
        <div class="delivery-fields col-12 collapse">
            <div class="row">
                <div class="col-12"><?= $form->field($model, 'address')->textarea(['rows' => 2]) ?></div>
                <div class="col-6"><?= $form->field($model, 'date_delivery')
                                        ->textInput(['type' => 'date', 'min' => date('Y-m-d', strtotime("+1 day")), 'max' => date('Y-m-d', strtotime("+30 day"))]) ?></div>
                <div class="col-6"><?= $form->field($model, 'time_delivery')->textInput(['type' => 'time', 'min' => '09:00', 'max' => '21:00', 'step' => 1800]) ?></div>
                <div class="col-12"><?= $form->field($model, 'comment')->textarea(['rows' => 2]) ?></div>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-orange w-100']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <?php Pjax::end() ?>
</div>
<?= $this->registerJsFile('/js/order-create.js', ['depends' => JqueryAsset::class]); ?>