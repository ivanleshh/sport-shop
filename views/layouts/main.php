<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Cart;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <!-- Start Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="top-middle">
                            <ul class="useful-links">
                                <li><a href="/site"><i class="bi bi-house-fill mx-2"></i>Главная</a></li>
                                <li><a href="about-us.html">О нас</a></li>
                                <li><a href="contact.html">Контакты</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="top-end">
                            <ul class="user-login">
                                <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin) : ?>
                                    <li><a href="/personal">Личный кабинет</a></li>
                                <?php endif; ?>
                                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) : ?>
                                    <li><a href="/admin-panel">Панель администратора</a></li>
                                <?php endif; ?>
                                <?php if (Yii::$app->user->isGuest) : ?>
                                    <li><a href="/site/login">Вход</a></li>
                                    <li><a href="/site/register">Регистрация</a></li>
                                <?php else : ?>
                                    <li class="user">
                                        <i class="lni lni-user"></i>
                                        <?= "Привет, " . Yii::$app->user->identity->login ?>
                                    </li>
                                    <li>
                                        <?= Html::beginForm(['/site/logout'])
                                            . Html::submitButton(
                                                'Выход <i class="bi bi-door-open-fill"></i>',
                                                ['class' => 'logout bg-transparent border-0']
                                            )
                                            . Html::endForm()
                                        ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Topbar -->
        <!-- Start Header Middle -->
        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-3 col-md-3 col-12 text-center">
                        <!-- Start Header Logo -->
                        <a class="navbar-logo" href="/">
                            <?= Html::img("/images/header_logo.jpg", ['class' => "w-100", 'alt' => "Logo"]) ?>
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-5 col-md-6 d-xs-none">
                        <!-- Start Main Menu Search -->
                        <div class="main-menu-search">
                            <!-- navbar search start -->
                            <div class="navbar-search search-style-5">
                                <div class="search-input">
                                    <input type="text" placeholder="Search">
                                </div>
                                <button class='btn btn-orange'>
                                    <i class="bi bi-search text-light"></i>
                                </button>
                            </div>
                            <!-- navbar search Ends -->
                        </div>
                        <!-- End Main Menu Search -->
                    </div>
                    <div class="nav-hotline col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area justify-content-end gap-4">
                            <div class="nav-hotline-ic">
                                <i class="bi bi-telephone-fill"></i>
                                <h3>Горячая линия:
                                    <span>(+100) 123 456 7890</span>
                                </h3>
                            </div>
                            <?php if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) : ?>
                                <div class="nav-actions d-flex text-white align-items-center gap-3">
                                    <div><?= Html::a('<i class="bi bi-bag-heart-fill"></i>', ['/personal/favourite-products'], ['class' => 'text-decoration-none']) ?></div>
                                    <div class="position-relative">
                                        <?= Html::a(
                                        '<i class="bi bi-cart4"></i>',
                                        ['/cart/index'],
                                        ['id' => 'btn-cart']) ?>
                                    
                                    <? Pjax::begin([
                                        'id' => 'cart-item-count',
                                        'enablePushState' => false,
                                        'timeout' => 5000,
                                        'options' => [
                                            'data-url' => '/cart/item-count',
                                        ]
                                    ]) ?>
                                    <span class="cart-item-count"><?= Cart::getItemCount() ?></span>
                                    <? Pjax::end() ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- End Header Middle -->
        <!-- Start Header Bottom -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">
                        <!-- Start Mega Category Menu -->
                        <div class="mega-category-menu">
                            <a href="/catalog" class="cat-button"><i class="lni lni-menu"></i>Каталог</a>
                            <ul class="sub-category">
                                <li><a href="product-grids.html">Electronics <i class="lni lni-chevron-right"></i></a>
                                    <ul class="inner-sub-category">
                                        <li><a href="product-grids.html">Digital Cameras</a></li>
                                        <li><a href="product-grids.html">Camcorders</a></li>
                                        <li><a href="product-grids.html">Camera Drones</a></li>
                                        <li><a href="product-grids.html">Smart Watches</a></li>
                                        <li><a href="product-grids.html">Headphones</a></li>
                                        <li><a href="product-grids.html">MP3 Players</a></li>
                                        <li><a href="product-grids.html">Microphones</a></li>
                                        <li><a href="product-grids.html">Chargers</a></li>
                                        <li><a href="product-grids.html">Batteries</a></li>
                                        <li><a href="product-grids.html">Cables & Adapters</a></li>
                                    </ul>
                                </li>
                                <li><a href="product-grids.html">accessories</a></li>
                                <li><a href="product-grids.html">Televisions</a></li>
                                <li><a href="product-grids.html">best selling</a></li>
                                <li><a href="product-grids.html">top 100 offer</a></li>
                                <li><a href="product-grids.html">sunglass</a></li>
                                <li><a href="product-grids.html">watch</a></li>
                                <li><a href="product-grids.html">man’s product</a></li>
                                <li><a href="product-grids.html">Home Audio & Theater</a></li>
                                <li><a href="product-grids.html">Computers & Tablets </a></li>
                                <li><a href="product-grids.html">Video Games </a></li>
                                <li><a href="product-grids.html">Home Appliances </a></li>
                            </ul>
                        </div>
                        <!-- End Mega Category Menu -->
                        <!-- Start Navbar -->
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="index.html" class="active" aria-label="Toggle navigation">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                            data-bs-target="#submenu-1-2" aria-controls="navbarSupportedContent"
                                            aria-expanded="false" aria-label="Toggle navigation">Pages</a>
                                        <ul class="sub-menu collapse" id="submenu-1-2">
                                            <li class="nav-item"><a href="about-us.html">About Us</a></li>
                                            <li class="nav-item"><a href="faq.html">Faq</a></li>
                                            <li class="nav-item"><a href="login.html">Login</a></li>
                                            <li class="nav-item"><a href="register.html">Register</a></li>
                                            <li class="nav-item"><a href="mail-success.html">Mail Success</a></li>
                                            <li class="nav-item"><a href="404.html">404 Error</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                            data-bs-target="#submenu-1-3" aria-controls="navbarSupportedContent"
                                            aria-expanded="false" aria-label="Toggle navigation">Shop</a>
                                        <ul class="sub-menu collapse" id="submenu-1-3">
                                            <li class="nav-item"><a href="product-grids.html">Shop Grid</a></li>
                                            <li class="nav-item"><a href="product-list.html">Shop List</a></li>
                                            <li class="nav-item"><a href="product-details.html">shop Single</a></li>
                                            <li class="nav-item"><a href="cart.html">Cart</a></li>
                                            <li class="nav-item"><a href="checkout.html">Checkout</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                            data-bs-target="#submenu-1-4" aria-controls="navbarSupportedContent"
                                            aria-expanded="false" aria-label="Toggle navigation">Blog</a>
                                        <ul class="sub-menu collapse" id="submenu-1-4">
                                            <li class="nav-item"><a href="blog-grid-sidebar.html">Blog Grid Sidebar</a>
                                            </li>
                                            <li class="nav-item"><a href="blog-single.html">Blog Single</a></li>
                                            <li class="nav-item"><a href="blog-single-sidebar.html">Blog Single
                                                    Sibebar</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="contact.html" aria-label="Toggle navigation">Contact Us</a>
                                    </li>
                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Nav Social -->
                    <div class="nav-social">
                        <h5 class="title">Мы в соц. сетях:</h5>
                        <ul>
                            <li>
                                <a href="#"><i class="bi bi-github w-100"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="bi bi-telegram"></i></a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Nav Social -->
                </div>
            </div>
        </div>
        <!-- End Header Bottom -->
    </header>
    <!-- End Header Area -->

    <!-- Start Hero Area -->
    <section id="main" class="hero-area my-4">
        <div class="container">

            <!-- Start Breadcrumbs -->
            <?php
            if (isset($this->params['breadcrumbs']) && !empty($this->params['breadcrumbs'])) { // Проверяем, есть ли breadcrumbs в параметрах
                $breadcrumbs = $this->params['breadcrumbs'];
                $lastItem = array_pop($breadcrumbs); // Извлекаем последний элемент (текущая страница)
            ?>
                <div class="breadcrumbs border rounded-4 mb-4">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="breadcrumbs-content">
                                    <h3 class="page-title fs-4"><?= is_array($lastItem) ? $lastItem['label'] : $lastItem ?></h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <ul class="breadcrumb-nav">
                                    <?php foreach ($breadcrumbs as $item): ?>
                                        <li>
                                            <?php if (isset($item['url'])): ?>
                                                <a href="<?= \yii\helpers\Url::to($item['url']) ?>">
                                                    <?= isset($item['icon']) ? '<i class="' . $item['icon'] . '"></i> ' : '' ?>
                                                    <?= $item['label'] ?>
                                                </a>
                                            <?php else: ?>
                                                <?= $item['label'] ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                    <li><?= is_array($lastItem) ? $lastItem['label'] : $lastItem ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End Breadcrumbs -->

            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </section>
    <!-- End Hero Area -->

    <?php if (isset($this->blocks['additional'])): ?>
        <?= $this->blocks['additional'] ?> <!-- Секция для дополнительного контента -->
    <?php endif; ?>

    <!-- Start Footer Area -->
    <footer class="footer">
        <!-- Start Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="inner-content">
                    <div class="row justify-content-center">
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="footer-logo">
                                <a href="/">
                                    <?= Html::img("/images/logo_dark.png", ['class' => "w-75", 'alt' => "Logo"]) ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12 align-self-center gx-3">
                            <div class="footer-newsletter gap-3">
                                <h4 class="title">
                                    Subscribe to our Newsletter
                                    <span>Get all the latest information, Sales and Offers.</span>
                                </h4>
                                <div class="newsletter-form-head">
                                    <form action="#" method="get" target="_blank" class="newsletter-form">
                                        <input name="EMAIL" placeholder="Email address here..." type="email">
                                        <div class="button">
                                            <button class="btn">Subscribe<span class="dir-part"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Top -->
        <!-- Start Footer Middle -->
        <div class="footer-middle">
            <div class="container">
                <div class="bottom-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-contact">
                                <h3>Get In Touch With Us</h3>
                                <p class="phone">Phone: +1 (900) 33 169 7720</p>
                                <ul>
                                    <li><span>Monday-Friday: </span> 9.00 am - 8.00 pm</li>
                                    <li><span>Saturday: </span> 10.00 am - 6.00 pm</li>
                                </ul>
                                <p class="mail">
                                    <a href="mailto:support@shopgrids.com">support@shopgrids.com</a>
                                </p>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer our-app">
                                <h3>Our Mobile App</h3>
                                <ul class="app-btn">
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="lni lni-apple"></i>
                                            <span class="small-title">Download on the</span>
                                            <span class="big-title">App Store</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="lni lni-play-store"></i>
                                            <span class="small-title">Download on the</span>
                                            <span class="big-title">Google Play</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Information</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">About Us</a></li>
                                    <li><a href="javascript:void(0)">Contact Us</a></li>
                                    <li><a href="javascript:void(0)">Downloads</a></li>
                                    <li><a href="javascript:void(0)">Sitemap</a></li>
                                    <li><a href="javascript:void(0)">FAQs Page</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Shop Departments</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Computers & Accessories</a></li>
                                    <li><a href="javascript:void(0)">Smartphones & Tablets</a></li>
                                    <li><a href="javascript:void(0)">TV, Video & Audio</a></li>
                                    <li><a href="javascript:void(0)">Cameras, Photo & Video</a></li>
                                    <li><a href="javascript:void(0)">Headphones</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Middle -->
        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="inner-content">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-12">
                            <div class="payment-gateway">
                                <span>We Accept:</span>
                                <img src="/front/images/footer/credit-cards-footer.png" alt="#">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="copyright">
                                <p>Developed by<a href="https://graygrids.com/" rel="nofollow"
                                        target="_blank">Javalets</a></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <ul class="socila">
                                <li>
                                    <span>Мы в соц.сетях:</span>
                                </li>
                                <li>
                                <a href="#"><i class="bi bi-github w-100"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="bi bi-telegram"></i></a>
                            </li>
                            </ul>
                            <div class="nav-social">
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Bottom -->
    </footer>
    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <? #= Alert::widget() 
            ?>
            <? #= $content 
            ?>
        </div>
    </main> -->

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>