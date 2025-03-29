<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Alert;
use yii\bootstrap5\Html;

?>

<div class="row g-0 rounded-3">
    <div class="login-info rounded-4 col-12 col-md-6">
        <div class="d-flex align-items-center justify-content-center h-100">
            <div class="col-10 col-xl-8 py-3 text-center">
                <img class="img-fluid mb-4" src="/images/logo.jpg" alt="logo">
                <hr class="border-danger mb-4">
                <h2 class="mb-4">Админ-авторизация</h2>
                <p class="m-0 fs-6">Вход в панель администратора осуществляется с помощью email и пароля</p>
                <a href="/" class="btn btn-secondary p-2 text-dark mt-4 rounded-4">
                    <i class="bi bi-arrow-90deg-up"></i>
                    <span class="">В магазин</span>
                </a>
            </div>
        </div>
    </div>
    <div class="login-form col-12 col-md-6">
        <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="row">
                <div class="col-12">
                    <div class="mb-4">
                        <h4>Пожалуйста, заполните указанные ниже поля:</h4>
                        <div class="d-inline-block my-2">
                            <span class="text-danger">*</span>
                            - обязательное поле
                        </div>
                        <hr class="border-2 border-secondary mb-4">
                    </div>
                </div>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'form-admin-login'
            ]) ?>
            <div class="row gy-3 gy-md-4 overflow-hidden">
                <div class="col-12">
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ]) ?>
                </div>
                <div class="col-12">
                    <div class="d-grid">
                        <?= Html::submitButton('Войти', ['class' => 'btn bsb-btn-xl btn-orange']) ?>
                    </div>
                </div>
                <div class="col-12">
                    <span class="mt-2">Данные администратора: sport-admin@ya.ru / Password1</span>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>