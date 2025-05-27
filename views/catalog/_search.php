<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CategorySearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-search">
    <?php $form = ActiveForm::begin([
        'id' => 'catalog-filter',
        'action' => ['view', 'id' => $model->category->id],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
        ],
    ]); ?>
    <div class="row align-items-end g-3">
        <div class="col-12 col-sm-6 col-md-5">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-7 col-sm-6 col-md-4">
            <?= $form->field($model, 'brand_id')->widget(Select2::class, [
                'data' => $brands,
                'options' => ['placeholder' => 'Выберите изготовителя'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        <div class="col-5 col-md-3 col-xl-2">
            <?= Html::a('Сбросить', ['view', 'id' => $model->category->id], ['class' => 'btn btn-outline-secondary w-100']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>