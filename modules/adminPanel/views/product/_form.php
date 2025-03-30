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

    <div class="row col-12">
        <div class="col-12 col-md-6">
            <?= FileInput::widget([
                'name' => 'imageFiles[]',
                'language' => 'ru',
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'previewFileType' => 'any',
                    'uploadUrl' => Url::to(['product/upload-images']),
                    'uploadExtraData' => [
                        'product_id' => $model->id ?: 0,
                    ],
                    'showRemove' => true,
                    'initialPreviewAsData' => true,
                    'overwriteInitial' => false,
                ],
            ]) ?>
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
            <div class="row mt-4">
                <div class="col-12 col-sm-6 col-md-12 col-xl-6"><?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?></div>
                <div class="col-6 col-sm-3 col-md-6 col-xl-3"><?= $form->field($model, 'price') ?></div>
                <div class="col-6 col-sm-3 col-md-6 col-xl-3"><?= $form->field($model, 'count') ?></div>
                <div class="col-12 col-xxl-7"><?= $form->field($model, 'description')->textarea(['rows' => 7]) ?></div>
                <div class="row col-12 col-xxl-5 pe-0">
                    <div class="col-12 col-sm-6 col-xxl-12 pe-0"><?= $form->field($model, 'category_id')->widget(Select2::class, [
                                                                        'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
                                                                        'options' => ['placeholder' => 'Выберите значение'],
                                                                        'pluginOptions' => [
                                                                            'allowClear' => true
                                                                        ],
                                                                    ]); ?></div>
                    <div class="col-12 col-sm-6 col-xxl-12 pe-0">
                        <?= $form->field($model, 'brand_id')->widget(Select2::class, [
                            'data' => ArrayHelper::map(Brand::find()->all(), 'id', 'title'),
                            'options' => ['placeholder' => 'Выберите значение'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?></div>
                    <div class="col-12 pe-0 form-group d-flex justify-content-end align-items-end">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-3 mt-md-0 col-12 col-md-6">
            <h4 class="fw-medium">Список характеристик для заполнения</h4>
            <div id="block-props" class="border p-3 mb-3 characters-block h-auto rounded-2">
                <?php if (is_null($model->category_id)) : ?>
                    <p>Выберите категорию, чтобы отобразить характеристики.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/change-props.js', ['depends' => JqueryAsset::class]) ?>