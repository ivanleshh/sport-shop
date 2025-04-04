<?php

use app\models\Brand;
use app\models\Category;
use app\models\Product;
use app\models\Typepay;
use hoomanMirghasemi\iviewer\IviewerGallery;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

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
            <div class="col-md-8 col-12 col-lg-5">
                <div class="product-images">
                    <main class="row align-items-center justify-content-center" id="gallery">
                        <?php if (count($model->productImages) > 1) : ?>
                            <div class="images col-9 col-sm-7 col-md-3 col-xl-2 d-flex d-md-grid gap-2 order-2 order-md-1">
                                <?php foreach ($model->productImages as $image)
                                    echo Html::img(Product::IMG_PATH . $image->photo, ['alt' => "product image", 'class' => 'gallery-img'])
                                ?>
                            </div>
                            <div class="main-img col-12 col-sm-8 col-md-9 col-xl-10 order-1 order-md-2">
                                <?= Html::img(Product::IMG_PATH . $model->productImages[0]->photo, ['alt' => "product image", 'id' => "current"]) ?>
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
    <div class="product-details-info mt-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-top-3" id="info-tab" data-bs-toggle="tab" data-bs-target="#product-info" type="button" role="tab" aria-controls="home" aria-selected="true">Основное</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-top-3" id="review-tab" data-bs-toggle="tab" data-bs-target="#product-reviews" type="button" role="tab" aria-controls="profile" aria-selected="false">Отзывы</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-top-3" id="product-tab" data-bs-toggle="tab" data-bs-target="#product-delivery" type="button" role="tab" aria-controls="contact" aria-selected="false">Доставка и оплата</button>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content single-block rounded-bottom-4">
            <div id="product-info" class="tab-pane fade show active row">
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
                        <h4>Характеристики</h4>
                        <ul class="features">
                            <?php foreach ($model->productProperties as $property) {
                                echo "<li><span>" . $property->property->title . ":</span> $property->property_value</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="product-reviews" class="tab-pane fade">
                <div class="info-body w-100">
                    <h4>Отзывы:</h4>

                    <?php Pjax::begin(); ?>

                    <?//= !Yii::$app->user->isGuest ? $this->render('_form-review.php', ['model' => $review]) : '' ?>

                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{pager}<div class='reviews row'>{items}</div>",
                        'itemOptions' => ['class' => 'item col-12 col-md-6'],
                        'itemView' => 'review',
                        'pager' => [
                            'class' => LinkPager::class,
                        ]
                    ]) ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
            <div id="product-delivery" class="tab-pane fade gap-5">
                <div class="info-body">
                    <h4>Информация по доставке:</h4>
                    <ul class="normal-list">
                        <li><span>Курьером:</span> завтра, от 150 руб</li>
                        <li><span>В пункте выдачи:</span> <?= Yii::$app->formatter->asDate(date('d-m-Y', strtotime("3 day")), 'php:d.m') ?>, бесплатно</li>
                    </ul>
                </div>
                <div class="info-body">
                    <h4>Оплата:</h4>
                    <ul class="features">
                        <?php foreach (Typepay::getTypePays() as $typePay) {
                            echo "<li><span>$typePay</span></li>";
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
</section>

<!-- End Item Details -->

<!-- Review Modal -->

<?= $this->registerJsFile('/js/images-change.js', ['depends' => JqueryAsset::class]) ?>