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

    <div class="row align-items-center">
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
        <div class="col-6 col-sm-4 col-md-3 col-xl-3 col-xxl-2">
            <?= Html::a('Сбросить', ['/admin-panel/category'], ['class' => 'btn btn-outline-secondary w-100']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>