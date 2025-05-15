<?php

/** @var yii\web\View $this */

use app\widgets\TrandingBrands;
use app\widgets\TrandingCategories;
use app\widgets\TrandingProducts;
use yii\bootstrap5\Html;

$this->title = 'My Yii Application';
?>

<?php $this->beginBlock('additional') ?>

<div class="row mt-3">
    <div class="col-lg-8 col-12 custom-padding-right">
        <div class="slider-head">
            <!-- Start Hero Slider -->
            <div class="hero-slider">
                <!-- Start Single Slider -->
                <div class="single-slider position-relative">
                    <div class="position-absolute bottom-0 start-0 w-100 h-100">
                        <?= Html::img('/images/main-page/slider1.jpg', ['class' => 'slider-img w-100 h-100 object-fit-cover', 'alt' => 'slide']) ?>
                    </div>
                    <div class="content">
                        <h2>
                            NutraBio Labs
                        </h2>
                        <p class="text-light fw-semibold">Поможет вам оптимизировать свой потенциал и укрепить здоровье с помощью высококачественных добавок для повышения производительности и улучшения самочувствия</p>
                        <div class="button">
                            <a href="#" class="btn">Перейти</a>
                        </div>
                    </div>
                </div>
                <div class="single-slider position-relative">
                    <div class="position-absolute bottom-0 start-0 w-100 h-100">
                        <?= Html::img('/images/main-page/slider3.jpg', ['class' => 'slider-img w-100 h-100 object-fit-cover', 'alt' => 'slide']) ?>
                    </div>
                    <div class="content">
                        <h2 class="text-danger">
                            MuscleTech
                        </h2>
                        <p class="text-light fw-semibold">Откройте для себя полную линейку MuscleTech, от энергетических предтренировочных комплексов, креатина для увеличения силы до белков для наращивания мышечной массы.</p>
                        <div class="button">
                            <a href="#" class="btn">Перейти</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Hero Slider -->
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="row">
            <div class="col-lg-12 col-md-6 col-12 md-custom-padding">
                <!-- Start Small Banner -->
                <div class="hero-small-banner position-relative">
                    <div class="position-absolute bottom-0 start-0 w-100 h-100">
                        <?= Html::a(Html::img('/images/main-page/slider2.jpg', ['class' => 'slider-img w-100 h-100 object-fit-cover', 'alt' => 'slide']), [''], ['class' => 'w-100 h-100']) ?>
                    </div>
                    <div class="content">
                        <h2 class="text-light">
                            <span class="text-success fw-bold">Теперь в наличии</span>
                            Gold Standart 100% Whey
                        </h2>
                        <h3 class="text-light">5199 ₽</h3>
                    </div>
                </div>
                <!-- End Small Banner -->
            </div>
            <div class="col-lg-12 col-md-6 col-12">
                <!-- Start Small Banner -->
                <div class="hero-small-banner style2">
                    <div class="content">
                        <h2>Распродажа только эту неделю!</h2>
                        <p class="text-secondary">Скидки до 50% на все товары интернет-магазина</p>
                        <div class="button">
                            <a class="btn" href="/catalog">Перейти</a>
                        </div>
                    </div>
                </div>
                <!-- Start Small Banner -->
            </div>
        </div>
    </div>
</div>

<!-- Start Trending Categories Area -->
<?= TrandingCategories::widget() ?>
<!-- End Trending Categories Area -->

<!-- Start Trending Brands Area -->
<?= TrandingBrands::widget() ?>
<!-- End Trending Brands Area -->

<!-- Start Call Action Area -->
<section class="call-action section position-relative py-4 px-2 bg-warning">
    <!-- <div class="position-absolute bottom-0 start-0 w-100 h-100">
        <?= Html::img('/images/main-page/call-to-action.png', ['class' => 'slider-img w-100 h-100 object-fit-cover', 'alt' => 'banner']) ?>
    </div> -->
    <div class="content">
        <h2 class="wow">Начни путь к своей лучшей форме уже сегодня</h2>
        <p class="fw-semibold">Выбери добавку под индивидуальные цели!</p>
        <div class="button">
            <a href="/catalog" class="btn">Перейти</a>
        </div>
    </div>
</section>
<!-- End Call Action Area -->

<!-- Start Shipping Info -->
<section class="shipping-info">
    <div class="container">
        <ul>
            <!-- Free Shipping -->
            <li>
                <div class="media-icon">
                    <i class="lni lni-delivery text-warning"></i>
                </div>
                <div class="media-body">
                    <h5>Бесплатная доставка</h5>
                    <span>При заказе от 2000 ₽</span>
                </div>
            </li>
            <!-- Money Return -->
            <li>
                <div class="media-icon">
                    <i class="lni lni-bar-chart text-warning"></i>
                </div>
                <div class="media-body">
                    <h5>Сравнение товаров</h5>
                    <span>Выбирайте по характеристикам</span>
                </div>
            </li>
            <!-- Support 24/7 -->
            <li>
                <div class="media-icon">
                    <i class="lni lni-credit-cards text-warning"></i>
                </div>
                <div class="media-body">
                    <h5>Онлайн оплата</h5>
                    <span>Безопасные платежные сервисы</span>
                </div>
            </li>
            <!-- Safe Payment -->
            <li>
                <div class="media-icon">
                    <i class="lni lni-reload text-warning"></i>
                </div>
                <div class="media-body">
                    <h5>Бесплатный возврат</h5>
                    <span>Покупки без проблем!</span>
                </div>
            </li>
        </ul>
    </div>
</section>
<!-- End Shipping Info -->
<?php $this->endBlock() ?>