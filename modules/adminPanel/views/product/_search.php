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

    <div class="row align-items-end">
        <div class="col-12 col-sm-6 col-xl-3 col-md-4"><?= $form->field($model, 'title') ?></div>
        <div class="col-12 col-sm-6 col-xl-3 col-md-4">
            <?= $form->field($model, 'category_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Выберите категорию'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        <div class="col-6 col-sm-4 col-xl-3 col-xxl-2">
            <?= $form->field($model, 'brand_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(Brand::find()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Выберите изготовителя'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        <div class="col-6 col-sm-4 col-xl-3 col-xxl-2 mb-3"><?= Html::a('Сбросить', ['/admin-panel/product'], ['class' => 'btn btn-outline-secondary w-100']) ?></div>
        <div class="col-6 col-sm-4 col-xl-3 col-xxl-2 mb-3">
            <?= Html::a('<i class="bi bi-plus-circle me-2"></i>' . 'Добавить', ['create'], ['class' => 'btn btn-success w-100']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>