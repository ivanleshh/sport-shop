<?php

use app\models\Brand;
use app\models\Category;
use app\models\Product;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Каталог', 'url' => ['/catalog']],
];

if (isset($model->category_id)) {
    array_map(function($title) {
        $this->params['breadcrumbs'][] = ['label' => $title, 'url' => ['/category/view', 'id' => Category::getIdByTitle($title)]]; 
    }, array_reverse($model->category->getParentRecursive()));
}

$this->params['breadcrumbs'][] = ['label' => $model->category->title, 'url' => ['/catalog/view','id' => $model->category->id]];
$this->params['breadcrumbs'][] = $model->title;

\yii\web\YiiAsset::register($this);
?>
<div class="product-view mt-5">
    <div class="product-info justify-content-center d-flex gap-3">
        <div class="product-info-photo w-25">
            <?= Html::img(Product::IMG_PATH . $model->photo, ['class' => 'w-100']) ?>
        </div>
        <div class="d-flex flex-column gap-3">
            <div class="d-flex gap-3 align-items-center">
                <?= Html::img(Brand::IMG_PATH . $model->brand->photo, ['class' => 'w-10']) ?>
                <h3><?= Html::encode($this->title) ?></h3>
            </div>

            <div class="d-flex gap-3">
                <?= Html::a(
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-slash-minus" viewBox="0 0 16 16">
                    <path d="m1.854 14.854 13-13a.5.5 0 0 0-.708-.708l-13 13a.5.5 0 0 0 .708.708M4 1a.5.5 0 0 1 .5.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2A.5.5 0 0 1 4 1m5 11a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5A.5.5 0 0 1 9 12"/>
                    </svg>' . 'В сравнение',
                    [''],
                    ['class' => 'd-flex gap-2 align-items-center text-decoration-none link-secondary']
                ) ?>
                <?= Html::a('🤍' . 'В избранное', [''], ['class' => 'd-flex gap-2 align-items-center text-decoration-none link-secondary']) ?>
            </div>
            <div class="d-flex gap-5">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'category_id',
                            'value' => $model->category->title,
                        ],
                        [
                            'attribute' => 'brand_id',
                            'value' => $model->brand->title,
                        ],
                    ]
                ]);
                ?>
                <div class="d-flex flex-column gap-2">
                    <span>Осталось <?= $model->count ?> шт.</span>
                    <h5 class="fw-bold"><?= $model->price ?> ₽</h5>
                    <?= Html::a('В корзину', [''], ['class' => 'btn bg-warning bg-gradient px-5 text-nowrap']) ?>
                </div>
            </div>
        </div>

    </div>

</div>