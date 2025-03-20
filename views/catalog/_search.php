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
        <div class="d-flex align-items-end gap-3">
            <span class="mb-2">🔎</span>
            <?= $form->field($model, 'title') ?>
            <?= Html::a('Сбросить', ['/catalog/view', 'id' => $model->category->id], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>