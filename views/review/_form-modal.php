<?php

use kartik\rating\StarRating;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="review-form">

    <?php Pjax::begin([
        'id' => 'form-review-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-review',
        'options' => [
            'data-pjax' => true,
        ]
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
            'size' => 'md',
        ]
    ]); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 2]) ?>

    <div class="form-group d-flex justify-content-end">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-orange py-2 px-4']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

</div>