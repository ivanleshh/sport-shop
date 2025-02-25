<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;
use yii\web\JqueryAsset;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h3><?= Html::encode($this->title) ?></h3>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'contact-form',
            ]); ?>

            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'surname') ?>
            <?= $form->field($model, 'login', ['enableAjaxValidation' => true]) ?>
            <?= $form->field($model, 'email', ['enableAjaxValidation' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="text-secondary fs-7 my-2">* Разрешено использование специальных символов: ^, +, -, <, ></div>
            <?= $form->field($model, 'password_repeat')->passwordInput() ?>
            <?= $form->field($model, 'personal')->checkbox() ?>
            <?= $form->field($model, 'rules')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>