<?php

use app\models\Brand;
use app\models\Category;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\adminPanel\models\CategorySearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="d-flex gap-3 align-items-end flex-wrap">
        <div class="align-self-center mt-4">🔎</div>
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'category_id')->widget(Select2::class, [
            'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
            'options' => ['placeholder' => 'Выберите категорию'],
            'pluginOptions' => [
                'width' => '200px',
                'allowClear' => true,
            ],
        ]); ?>
        <?= $form->field($model, 'brand_id')->widget(Select2::class, [
            'data' => ArrayHelper::map(Brand::find()->all(), 'id', 'title'),
            'options' => ['placeholder' => 'Выберите категорию'],
            'pluginOptions' => [
                'width' => '200px',
                'allowClear' => true,
            ],
        ]); ?>
        <div class="form-group d-flex gap-3">
            <?= Html::a('Сбросить', ['/admin-panel/product'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>