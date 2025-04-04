<?php

use kartik\rating\StarRating;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="review-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-review',
    ]); ?>

    <?= Html::hiddenInput('parent_id', $parent_id ?? null) ?>

    <?= StarRating::widget([
        'model' => $model,
        'attribute' => 'stars',
        'pluginOptions' => [
            'theme' => 'krajee-uni',
            'filledStar' => '★',
            'emptyStar' => '☆',
            'step' => 1,
            'size' => 'sm',
        ]
    ]); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 2]) ?>

    <div class="form-group d-flex justify-content-end">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>