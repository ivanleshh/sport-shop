<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    'Авторизация',
];
?>
<div class="hero-content site-login">
    <div class="row">
        <div class="col-lg-4">

            <h5 class="fs-6 mb-2">Пожалуйста, заполните указанные ниже поля:</h5>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'login')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

            <div class="form-group">
                <div class="text-end">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-orange', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="row col-lg-8 justify-content-center align-items-center mt-4 gap-4 gap-md-2 gap-lg-4 gap-xl-0">
            <div class="col-12 col-md-5 col-lg-4 d-flex flex-column gap-3 align-items-center">
                <h6 class="my-lg-0">Нет учетной записи?</h6>
                <div>
                    <a class="btn btn-warning" href="/site/register">Зарегистрироваться</a>
                </div>
            </div>
            <span class="col-12 col-md-1 text-center">или</span>
            <ul class="col-12 col-md-5 col-lg-4 d-flex flex-column gap-2 text-secondary text-center" style="list-style-type: none;">
                <h6>Используйте данные:</h6>
                <li><strong>Клиент 1:</strong></li>
                <li>demo-user / P1ssw0rd^1-7</li>
                <li><strong>Клиент 2:</strong></li>
                <li>demo-user1 / Pa66word+>Str0ng</li>
            </ul>
        </div>
    </div>
</div>