<?php

use app\models\Brand;
use app\models\Category;
use app\models\Product;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use yii\web\JqueryAsset;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row col-12">
        <div class="col">
            <?php if (isset($model->photo)) : ?>
                <div class="d-flex flex-column align-items-center">
                    <p>Загруженное фото</p>
                    <div class="text-center"><?= Html::img(Product::IMG_PATH . $model->photo, ['class' => 'w-75']); ?></div>
                </div>
                
            <?php endif; ?>
            <?= $form->field($model, 'imageFile')->fileInput() ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'count')->textInput() ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <div class="d-flex gap-3 justify-content-between">
                <div class="d-flex gap-3 flex-wrap">
                    <?= $form->field($model, 'category_id')->widget(Select2::class, [
                        'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
                        'options' => ['placeholder' => 'Выберите значение'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                    <?= $form->field($model, 'brand_id')->widget(Select2::class, [
                        'data' => ArrayHelper::map(Brand::find()->all(), 'id', 'title'),
                        'options' => ['placeholder' => 'Выберите значение'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="form-group d-flex justify-content-end align-items-center mt-4">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-auto']) ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-6">
            <h4>Список характеристик для заполнения</h4>
            <div id="block-props" class="border p-3 mb-3 characters-block h-auto">
                <?php if (is_null($model->category_id)) : ?>
                    <p>Выберите категорию, чтобы отобразить характеристики.</p>
                <?php endif; ?>
                    <!-- <div class="border border-success rounded-3 p-3 my-3 category-props col-lg-6 w-100">
                        <div class="d-flex gap-3 mt-2 flex-wrap">
                            
                        </div>
                    </div> -->
               
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/change-props.js', ['depends' => JqueryAsset::class]) ?>
