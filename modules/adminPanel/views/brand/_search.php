<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\adminPanel\models\BrandSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="brand-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row align-items-end">
        <div class="col-12 col-sm-4 col-xxl-3">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-6 col-sm-4 mb-3 col-xxl-3"><?= Html::a('Сбросить', ['/admin-panel/brand'], ['class' => 'btn btn-outline-secondary w-100']) ?></div>
        <div class="col-6 col-sm-4 mb-3 col-xxl-3">
            <?= Html::a('<i class="bi bi-plus-circle me-2"></i>' . 'Добавить', ['create'], 
            ['class' => 'btn btn-brand-create btn-success w-100']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>