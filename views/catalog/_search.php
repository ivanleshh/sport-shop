<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CategorySearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-search my-2">

    <?php $form = ActiveForm::begin([
        'id' => 'catalog-filter',
        'action' => ['view', 'id' => $model->category->id],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
        ],
    ]); ?>

    <div class="d-flex gap-3 align-items-end flex-wrap">
        <div class="d-flex align-self-center align-items-center gap-3">
            🔎
            <?= $form->field($model, 'title') ?>
            <?= Html::a('Сбросить', ['/catalog/view', 'id' => $model->category->id], ['class' => 'btn btn-outline-secondary mt-2']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>