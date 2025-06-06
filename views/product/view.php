<?php

use app\models\Brand;
use app\models\Category;
use app\models\Product;
use app\models\Typepay;
use app\widgets\Alert;
use kartik\rating\StarRating;
use kartik\rating\StarRatingAsset;
use Symfony\Component\VarDumper\VarDumper;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

StarRatingAsset::register($this);

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

$mediumStars = $model->mediumStars;
$countReviews = $model->countReviews;

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
                        <?php endif; ?>
                        <div class="main-img col-12 col-sm-8 col-md-9 col-xl-10 order-1 order-md-2 mb-3">
                            <?= Html::img(isset($model->productImages[0]->photo) ? Product::IMG_PATH . $model->productImages[0]->photo : Product::NO_PHOTO, ['alt' => "product image", 'id' => "current"]) ?>
                        </div>
                    </main>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 col-12">
                <div class="product-info">
                    <h3 class="title fs-5"><?= $model->title ?></h3>
                    <div class="d-flex justify-content-between align-items-center flex-wrap border-bottom pb-3 gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <i class="bi bi-star-fill text-warning fs-6"></i>
                                <span class="fw-bold"><?= $mediumStars ?> </span>
                                <span class="fs-5">|</span>
                                <div>Отзывов: <?= $countReviews ?></div>
                            </div>
                            <h3 class="price mt-2"><?= $model->price ?> ₽<span class="fs-6"><?= round($model->price * 1.1) ?> ₽</span></h3>
                            <p class="info-text">Осталось <?= $model->count ?> шт.</p>
                        </div>
                        <div class="product-info-brand">
                            <?= Html::img(Brand::IMG_PATH . $model->brand->photo, ['alt' => 'brand']) ?>
                        </div>
                    </div>

                    <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin) : ?>

                        <div class="bottom-content">

                            <?php
                            Pjax::begin([
                                'id' => 'product-buttons-pjax',
                                'enablePushState' => false,
                                'timeout' => 5000,
                                'enableReplaceState' => false,
                            ]);
                            $pjx = '#product-buttons-pjax'
                            ?>

                            <div class="row align-items-end justify-content-end gy-3">
                                <div class="col-12 col-sm-7 col-xxl-5">
                                    <div class="cart-button">
                                        <?php if (isset($model->cartItems[0])) {
                                            echo '<div class="d-flex align-items-center justify-content-center gap-3">'
                                                . Html::a('Оформить', ['/personal/orders/create'], ['class' => 'btn btn-orange w-100']) .
                                                '<div class="d-flex gap-3 align-items-center text-dark">'
                                                . Html::a(
                                                    '-',
                                                    ['/cart/dec-item', 'item_id' => $model->cartItems[0]->id],
                                                    ['class' => 'btn btn-outline-secondary btn-cart-item-dec px-3', 'data-pjx' => $pjx]
                                                ) . $model->cartItems[0]->product_amount . Html::a(
                                                    '+',
                                                    ['/cart/inc-item', 'item_id' => $model->cartItems[0]->id],
                                                    ['class' => 'btn btn-outline-secondary btn-cart-item-inc px-3', 'data-pjx' => $pjx]
                                                ) .
                                                '</div>
                                        </div>';
                                        } else {
                                            echo Html::a(
                                                'В корзину',
                                                ['/cart/add', 'product_id' => $model->id],
                                                ['class' => 'btn-cart-add btn btn-warning w-100', 'data-pjx' => $pjx]
                                            );
                                        } ?>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-5 col-xxl-4">
                                    <?php
                                    $favourite = empty($model->favouriteProducts[0]->status);
                                    echo Html::a(
                                        '<i class="bi bi-suit-heart-fill me-2"></i>' . ($favourite ? 'В избранное' : 'В избранном'),
                                        ['/catalog/favourite'],
                                        ['data-id' => $model->id, 'data-pjx' => $pjx, 'class' => "btn btn-favourite w-100 btn-" . ($favourite ? "outline-secondary" : "secondary") . " text-decoration-none"]
                                    );
                                    ?>
                                </div>
                                <div class="col-12 col-sm-5 col-xxl-3">
                                    <?php
                                    $compare = empty($model->compareProducts[0]->status);
                                    echo Html::a(
                                        '<i class="bi bi-bar-chart-line-fill me-2"></i>' . ($compare ? 'В сравнение' : 'В сравнении'),
                                        ['/catalog/compare'],
                                        ['data-id' => $model->id, 'data-pjx' => $pjx, 'class' => "btn btn-compare w-100 btn-" . ($compare ? "outline-secondary" : "secondary") . " text-decoration-none"]
                                    );
                                    ?>
                                </div>
                            </div>

                            <?php Pjax::end() ?>
                        </div>

                    <?php endif; ?>
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
                        <?php if ($model->productProperties) : ?>
                            <ul class="features">
                                <?php foreach ($model->productProperties as $property) {
                                    echo "<li><span>" . $property->property->title . ":</span> $property->property_value</li>";
                                }
                                ?>
                            </ul>
                        <?php else : ?>
                            <span>Ничего не найдено</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="product-reviews" class="info-body tab-pane fade">

                <?php Pjax::begin([
                    'id' => 'product-reviews-pjax',
                    'enablePushState' => false,
                    'timeout' => 5000,
                ]); ?>

                <div class="row">
                    <div class="d-flex flex-column gap-3 col-12 col-lg-4 mb-2">
                        <div class="d-flex align-items-center justify-content-center gap-3 border rounded-4 py-2 px-3">
                            <h2><?= $mediumStars ?></h2>
                            <div class="position-relative">
                                <?= StarRating::widget([
                                    'name' => 'mediumStars',
                                    'value' => $mediumStars,
                                    'pluginOptions' => [
                                        'theme' => 'krajee-uni',
                                        'readonly' => true,
                                        'showClear' => false,
                                        'showCaption' => false,
                                        'size' => 'sm',
                                    ],
                                ]); ?>
                                <div class="position-absolute right-50 left-50 top-50 mt-1">Всего отзывов: <?= $countReviews ?></div>
                            </div>
                        </div>
                        <h5 class="fs-6 fw-bold">Есть что рассказать?</h5>
                        <span>Оцените товар, ваш опыт будет полезен</span>
                        <div class="mb-2">
                            <?php if (Yii::$app->user->isGuest) : ?>
                                <?= Html::a("Войдите, чтобы оценить товар", ['/site/login'], ['class' => 'btn btn-orange px-4 py-2']) ?>
                            <?php elseif (!Yii::$app->user->identity->isAdmin) : ?>
                                <?= Html::a(
                                    "Оценить товар",
                                    ['/review/create', 'product_id' => $model->id],
                                    ['class' => 'btn btn-orange btn-add-review px-4 py-2']
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">

                        <?= ListView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "{pager}<div class='reviews row gap-3'>{items}</div>{pager}",
                            'itemOptions' => ['class' => 'item col-12'],
                            'itemView' => '/review/view',
                            'pager' => [
                                'class' => LinkPager::class,
                            ]
                        ]) ?>

                    </div>
                </div>

                <?php Pjax::end(); ?>
            </div>
            <div id="product-delivery" class="tab-pane fade gap-3 gap-md-5 flex-wrap">
                <div class="info-body">
                    <h4>Информация по доставке:</h4>
                    <ul class="normal-list">
                        <li><span>Курьером:</span> завтра, от 300 руб</li>
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

<?= \app\widgets\RecentlyViewed::widget(['excludeId' => $model->id]) ?>

<?php
if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) {
    Modal::begin([
        'id' => 'review-modal',
        'title' => "Оценка товара",
        'size' => 'model-md',
    ]);
    echo $this->render('/review/_form-modal.php', ['model' => $model_review]);
    Modal::end();

    $this->registerJsFile('/js/review.js', ['depends' => JqueryAsset::class]);
}
?>

<?= $this->registerJsFile('/js/images-change.js', ['depends' => JqueryAsset::class]) ?>