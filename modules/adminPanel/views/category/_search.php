<?php

use app\models\Category;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\adminPanel\models\CategorySearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row align-items-end">
        <div class="col-12 col-sm-6 col-md-4 col-xl-4 col-xxl-3">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-xl-4 col-xxl-3">
            <?= $form->field($model, 'parent_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Выберите родительскую категорию'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        <div class="col-6 mb-3 col-md-4 col-xl-3">
            <?= Html::a('Сбросить', ['/admin-panel/category'], ['class' => 'btn btn-outline-secondary w-100']) ?>
        </div>
        <div class="col-6 mb-3 col-xxl-3 col-md-4 col-xxl-2">
            <?= Html::a('<i class="bi bi-plus-circle me-2"></i>' . 'Добавить', ['create'], ['class' => 'btn btn-success w-100']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>