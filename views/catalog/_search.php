<?php

use yii\helpers\Html;
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
        <div class="col-12 col-sm-6 col-md-4 col-lg-6">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-6 col-md-3 col-lg-4 col-xl-3">
            <?= Html::a('Сбросить', ['view', 'id' => $model->category->id], ['class' => 'btn btn-outline-secondary w-100']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>