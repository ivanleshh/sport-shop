<?php

use app\models\Category;
use app\models\Property;
use yii\bootstrap5\Html;
use yii\web\JqueryAsset;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Json;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */

$properties = ArrayHelper::map(Property::find()->all(), 'id', 'title');
$this->registerJs("var propertyOptions = " . Json::encode($properties) . ";", \yii\web\View::POS_HEAD);
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['options' => [
        'id' => 'form-category',
        'enctype' => 'multipart/form-data'
    ]]); ?>

    <div class="row">
        <div class="col">
            <?php if (isset($model->photo)) : ?>
                <div class="d-flex flex-column align-items-center">
                    <p>Загруженное фото</p>
                    <div class="text-center"><?= Html::img(Category::IMG_PATH . $model->photo, ['class' => 'w-75']); ?></div>
                </div>
            <?php endif; ?>
            <?= $form->field($model, 'imageFile')->fileInput() ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <div class="d-flex gap-3 justify-content-between">
                <div class="d-flex gap-3 align-items-center">
                    <?= $form->field($model, 'parent_id')->widget(Select2::class, [
                        'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
                        'options' => ['placeholder' => 'Выберите значение'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="form-group d-flex justify-content-end align-items-center">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-auto']) ?>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>Список характеристик</h4>
            <div id="block-props" class="border p-3 mb-3 characters-block">
                <?php foreach ($categoryProperties as $key => $prop) : ?>
                    <div class="border p-3 my-3 category-props col-lg-6 w-100" data-index="<?= $key ?>">
                        <div class="d-flex justify-content-end">
                            <div class="btn-group d-flex" role="group">
                                <button type="button" class="btn btn-danger btn-remove">-</button>
                                <button type="button" class="btn btn-success btn-add">+</button>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="d-flex flex-column gap-2 justify-content-center">
                                <?= $form->field($prop, "[$key]property_id")->widget(Select2::class, [
                                    'data' => $properties,
                                    'options' => [
                                        'placeholder' => 'Выберите значение',
                                        'id' => "categoryproperty-{$key}-property_id",
                                        'class' => 'form-control property-select',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label('Выбрать из списка'); ?>
                                <?= $form->field($prop, "[$key]property_title")->textInput([
                                    'maxlength' => true,
                                    'id' => "categoryproperty-{$key}-property_title",
                                    'class' => 'form-control props-title',
                                ])->label('Новая характеристика') ?>
                            </div>

                            <?= $form->field($prop, "[$key]property_value")->textInput() ?>
                            <?= $form->field($prop, "[$key]id")->hiddenInput(['id' => "categoryproperty-{$key}-id"])->label(false) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= $this->registerJsFile('/js/props.js', ['depends' => JqueryAsset::class]) ?>