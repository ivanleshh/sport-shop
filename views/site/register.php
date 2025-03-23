<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;
use yii\web\JqueryAsset;

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    'Регистрация',
];
?>
<div class="site-register hero-content">
    <div class="row align-items-center">
        <div class="col-lg-6">

            <?php $form = ActiveForm::begin([
                'id' => 'contact-form',
            ]); ?>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <?= $form->field($model, 'name') ?>
                </div>
                <div class="col-12 col-sm-6">
                    <?= $form->field($model, 'surname') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <?= $form->field($model, 'login', ['enableAjaxValidation' => true]) ?>
                </div>
                <div class="col-12 col-sm-6">
                    <?= $form->field($model, 'email', ['enableAjaxValidation' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="col-12 col-sm-6">
                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                </div>
            </div>

            <div class="text-secondary fs-7 mb-3 text-center">* Разрешено использование специальных символов: ^, +, -, <,>
            </div>
            <?= $form->field($model, 'personal')->checkbox() ?>
            <?= $form->field($model, 'rules')->checkbox() ?>

            <div class="form-group text-end">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="col-lg-6 d-lg-flex align-items-center text-end justify-content-center gap-3 mt-2">
            <h6 class="my-3 my-lg-0">Уже зарегистрированы?</h6>
            <div>
                <a class="btn btn-warning" href="/site/login">Войти</a>
            </div>
        </div>
    </div>

</div>