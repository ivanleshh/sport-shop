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

    <div class="row align-items-center">
        <div class="col-6 col-md-4 col-xl-3"><?= $form->field($model, 'title') ?></div>
        <div class="col-6 col-md-4 col-xl-3">
            <?= $form->field($model, 'category_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Выберите категорию'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        <div class="col-6 col-md-4 col-xl-3">
            <?= $form->field($model, 'brand_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(Brand::find()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Выберите категорию'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        <div class="col-6 col-sm-3 col-md-3 col-xl-2"><?= Html::a('Сбросить', ['/admin-panel/product'], ['class' => 'btn btn-outline-secondary w-100']) ?></div>
    </div>

    <?php ActiveForm::end(); ?>
</div>