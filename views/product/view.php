<?php

use app\models\Brand;
use app\models\Category;
use app\models\Product;
use hoomanMirghasemi\iviewer\IviewerGallery;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Каталог', 'url' => ['/catalog']],
];

if (isset($model->category_id)) {
    array_map(function ($title) {
        $this->params['breadcrumbs'][] = ['label' => $title, 'url' => ['/catalog/view', 'id' => Category::getIdByTitle($title)]];
    }, array_reverse($model->category->getParentRecursive()));
}

$this->params['breadcrumbs'][] = ['label' => $model->category->title, 'url' => ['/catalog/view', 'id' => $model->category->id]];
$this->params['breadcrumbs'][] = $model->title;
\yii\web\YiiAsset::register($this);

?>

<section class="item-details hero-content">
    <div class="top-area rounded-4">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-5 col-md-8 col-12">
                <div class="product-images">
                    <main id="gallery">
                        <div class="main-img">
                            <?= Html::img(Product::IMG_PATH . $model->productImages[0]->photo, ['alt' => "product image", 'id' => "current"]) ?>
                        </div>
                        <?php if (count($model->productImages) > 1) : ?>
                            <div class="images">
                                <?php foreach ($model->productImages as $image)
                                    echo Html::img(Product::IMG_PATH . $image->photo, ['alt' => "product image", 'id' => "current"])
                                ?>
                            </div>
                        <?php endif; ?>
                    </main>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 col-12">
                <div class="product-info">
                    <div class="d-flex gap-3 justify-content-between align-items-center mb-3 mb-sm-0">
                        <h2 class="title"><?= $model->title ?></h2>
                        <div class="product-info-brand">
                            <?= Html::img(Brand::IMG_PATH . $model->brand->photo, ['alt' => 'brand']) ?>
                        </div>
                    </div>
                    <h3 class="price"><?= $model->price ?> ₽<span class="fs-6"><?= round($model->price * 1.1) ?> ₽</span></h3>
                    <p class="info-text">Осталось <?= $model->count ?> шт.</p>
                    <div class="bottom-content">
                        <div class="row align-items-end">
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="button cart-button">
                                    <button class="btn">В корзину</button>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="wish-button">
                                    <button class="btn"><i class="bi bi-plus-slash-minus"></i>В сравнение</button>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="wish-button">
                                    <button class="btn"><i class="lni lni-heart"></i>В избранное</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-details-info">
        <div class="single-block rounded-4">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="info-body custom-responsive-margin">
                        <h4>Описание</h4>
                        <p><?= $model->description ?></p>
                        <h4>Особенности</h4>
                        <ul class="features">
                            <li><span>Название:</span> <?= $model->title ?></li>
                            <li><span>Категория:</span> <?= $model->category->title ?></li>
                            <li><span>Производитель:</span> <?= $model->brand->title ?></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="info-body">
                        <h4>Specifications</h4>
                        <ul class="normal-list">
                            <li><span>Weight:</span> 35.5oz (1006g)</li>
                            <li><span>Maximum Speed:</span> 35 mph (15 m/s)</li>
                            <li><span>Maximum Distance:</span> Up to 9,840ft (3,000m)</li>
                            <li><span>Operating Frequency:</span> 2.4GHz</li>
                            <li><span>Manufacturer:</span> GoPro, USA</li>
                        </ul>
                        <h4>Информация по доставке:</h4>
                        <ul class="normal-list">
                            <li><span>Курьером:</span> завтра, от 150 руб</li>
                            <li><span>В пункте выдачи:</span> <?= Yii::$app->formatter->asDate(date('d-m-Y', strtotime("3 day")), 'php:d.m') ?>, бесплатно</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Item Details -->

<!-- Review Modal -->