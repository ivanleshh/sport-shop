<?php

use app\models\Brand;
use app\models\Category;
use app\models\Product;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use yii\web\JqueryAsset;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use kartik\icons\FontAwesomeAsset;

FontAwesomeAsset::register($this);

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="m-0 row col-12">
        <div class="col-12 col-xl-6 mt-2">
            <?/*= $form->field($uploadForm, 'imageFiles[]', ['enableClientValidation' => true])->widget(FileInput::class, [
                'pluginOptions' => [
                    'language' => 'ru',
                    'options' => [
                        'multiple' => true,
                    ],
                    'previewFileType' => 'image',
                    'showUpload' => false,
                    'showRemove' => true,
                    'initialPreviewAsData' => true,
                    'overwriteInitial' => false,
                    'maxFileSize' => 2800,
                    'initialPreview' => !empty($product->productImages) ? array_map(function ($image) {
                        return Yii::getAlias('@web/images/products/') . $image->photo;
                    }, $product->productImages) : [],
                    'initialPreviewConfig' => !empty($product->productImages) ? array_map(function ($image) {
                        return ['key' => $image->id];
                    }, $product->productImages) : [],
                ],
            ]) */ ?>
            <div class="row">
                <div class="col-12 mb-3">
                    <?= FileInput::widget([
                        'name' => 'imageFiles[]',
                        'language' => 'ru',
                        'options' => ['multiple' => true],
                        'pluginOptions' => [
                            'previewFileType' => 'any',
                            'showUpload' => false,
                            'showRemove' => true,
                            'initialPreviewAsData' => true,
                            'overwriteInitial' => false,
                            'initialPreview' => array_map(fn($image) => Product::IMG_PATH . $image->photo, $model->productImages),
                            'initialPreviewConfig' => array_map(fn($image) => ['caption' => $image->photo], $model->productImages),
                        ],
                    ]) ?>
                </div>
                <div class="col-12 col-sm-6"><?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?></div>
                <div class="col-6 col-sm-3"><?= $form->field($model, 'price') ?></div>
                <div class="col-6 col-sm-3"><?= $form->field($model, 'count') ?></div>

                <div class="col-12 col-sm-6">
                    <?= $form->field($model, 'category_id')->widget(Select2::class, [
                        'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
                        'options' => ['placeholder' => 'Выберите значение'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?></div>
                <div class="col-12 col-sm-6">
                    <?= $form->field($model, 'brand_id')->widget(Select2::class, [
                        'data' => ArrayHelper::map(Brand::find()->all(), 'id', 'title'),
                        'options' => ['placeholder' => 'Выберите значение'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>

                <div class="col-12"><?= $form->field($model, 'description')->textarea(['rows' => 7]) ?></div>
                <div class="col-12 form-group d-flex justify-content-end align-items-end">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <div class="mt-3 mt-md-1 col-12 col-xl-6">
            <h4 class="fs-5">Характеристики товара</h4>
            <?= Html::hiddenInput('product_id', $model->id ?: 0, ['id' => 'product-id']) ?>
            <div id="block-props" class="d-flex flex-wrap gap-3 border rounded-4 p-3 mt-3 characters-block h-auto"></div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/change-props.js', ['depends' => JqueryAsset::class]) ?>