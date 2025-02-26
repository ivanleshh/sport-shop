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
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="d-flex gap-3 align-items-end flex-wrap">
        <div class="align-self-center">🔎</div>
        <?= $form->field($model, 'title') ?>
        <div class="form-group d-flex gap-3">
            <?= Html::a('Сбросить', ['/catalog'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
