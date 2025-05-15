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

    <?php $form = ActiveForm::begin([
        'id' => 'product-form',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <div class="m-0 row col-12">
        <div class="col-12 col-xl-7 mt-2">
            <div class="row">
                <div class="col-12 mb-3">
                    <?= FileInput::widget([
                        'name' => 'imageFiles[]',
                        'language' => 'ru',
                        'options' => [
                            'multiple' => true,
                            'id' => 'product-file-input',
                        ],
                        'pluginOptions' => [
                            'previewFileType' => 'image',
                            'uploadUrl' => Url::to(['product/upload-images']),
                            'uploadExtraData' => new \yii\web\JsExpression('function() {
                                return { "product_id": $("#product-id").val() || 0 };
                            }'),
                            'deleteUrl' => Url::to(['product/delete-image']), // удаление существующих картинок
                            'showRemove' => true,
                            'showCancel' => false,
                            'showUpload' => false, // загрузка через форму
                            'initialPreviewAsData' => true,
                            'overwriteInitial' => false,
                            'maxFileCount' => 10,
                            'initialPreview' => array_map(fn($image) => Product::IMG_PATH . $image->photo, $model->productImages),
                            'initialPreviewConfig' => array_map(fn($image) => [
                                'caption' => $image->photo,
                                'key' => $image->id,
                                'url' => Url::to(['product/delete-image', 'id' => $image->id]), // URL для удаления
                            ], $model->productImages),
                            'filebatchuploadcomplete' => new \yii\web\JsExpression('function(event, files, extra) {
                                var productId = $("#product-id").val();
                                window.location = "/admin-panel/product";
                            }'),
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
        <div class="mt-3 mt-md-1 col-12 col-xl-5">
            <h4 class="fs-5">Характеристики товара</h4>
            <?= Html::hiddenInput('product_id', $model->id ?: 0, ['id' => 'product-id']) ?>
            <div id="block-props" class="d-flex flex-wrap gap-3 border rounded-4 p-3 mt-3 characters-block h-auto"></div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/image-control.js', ['depends' => JqueryAsset::class]) ?>
<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/change-props.js', ['depends' => JqueryAsset::class]) ?>