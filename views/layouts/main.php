<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Cart;
use app\models\Category;
use app\widgets\Alert;
use kazda01\search\SearchInput;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\VarDumper;
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

    <!-- Start Header Area -->
    <header class="header navbar-area position-relative">
        <!-- Start Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="top-middle">
                            <ul class="useful-links">
                                <li><a href="/site"><i class="bi bi-house-fill mx-2"></i>Главная</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="top-end">
                            <ul class="user-login">

                                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) : ?>
                                    <li class="d-none d-sm-inline-block"><a href="/admin-panel">Панель Администратора</a></li>
                                <?php endif; ?>

                                <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin) : ?>
                                    <li class="d-none d-sm-inline-block"><a href="/personal">Личный кабинет</a></li>
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
                                                'Выход <i class="bi bi-door-open-fill fs-6"></i>',
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
                    <div class="col-lg-3 col-md-3 col-12 text-center text-md-start">
                        <!-- Start Header Logo -->
                        <a class="navbar-logo" href="/">
                            <?= Html::img("/images/header_logo.jpg", ['class' => "w-100", 'alt' => "Logo"]) ?>
                        </a>
                        <!-- End Header Logo -->
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                        <!-- Start Main Menu Search -->
                        <div class="main-menu-search">
                            <?= SearchInput::widget([
                                'search_id' => 'search',
                                'placeholder' => 'Поиск...',
                                'wrapperClass' => 'navbar-search search-style-5',
                                'buttonContent' => '<i class="bi bi-search text-light"></i>',
                                'buttonClass' => 'btn btn-orange',
                                'inputClass' => 'px-3 py-2',
                            ]); ?>
                        </div>
                        <!-- End Main Menu Search -->
                    </div>
                    <div class="nav-hotline col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area justify-content-end gap-4">
                            <div class="nav-hotline-ic">
                                <i class="bi bi-telephone-fill"></i>
                                <h3>Горячая линия:
                                    <span>+7(123)-456-78-90</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- End Header Middle -->
        <!-- Start Header Bottom -->
        <div class="container header-bottom">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">
                        <!-- Start Mega Category Menu -->
                        <div class="mega-category-menu">
                            <a href="/catalog" class="cat-button"><i class="lni lni-menu"></i>Каталог</a>
                            <ul class="sub-category">
                                <? foreach (Category::find()->select(['id', 'parent_id', 'title'])->where(['parent_id' => null])->asArray()->all() as $parent) {
                                    echo "<li>" . Html::a($parent['title'] . '<i class="lni lni-chevron-right"></i>', ['catalog/view', 'id' => $parent['id']]) .
                                        '<ul class="inner-sub-category">';
                                    foreach (Category::find()->select(['id', 'title'])->where(['parent_id' => $parent['id']])->asArray()->all() as $child) {
                                        echo "<li>" . Html::a($child['title'], ['/catalog/view', 'id' => $child['id']]) . '</li>';
                                    }
                                    echo '</ul><li>';
                                }
                                ?>
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
                                        <a href="/">Главная</a>
                                    </li>
                                    <li class="nav-item d-lg-none">
                                        <a href="/catalog">Каталог</a>
                                    </li>
                                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) : ?>
                                        <li class="nav-item">
                                            <a href="/admin-panel">Панель администратора</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin) : ?>
                                        <li class="nav-item">
                                            <a href="/personal">Личный кабинет</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/personal/orders">Мои заказы</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Nav Social -->
                    <div class="nav-social">
                        <ul>
                            <li>
                                <?= Html::a('<i class="bi bi-bar-chart-line"></i>', ['/personal/compare-products']) ?>
                            </li>
                            <li>
                                <?= Html::a('<i class="bi bi-bag-heart-fill"></i>', ['/personal/favourite-products'], ['class' => 'text-decoration-none']) ?>
                            </li>
                            <li class="position-relative">
                                <?= Html::a(
                                    '<i class="bi bi-cart4"></i>',
                                    [!Yii::$app->user->isGuest ? '/cart/index' : '/site/login'],
                                    ['id' => 'btn-cart']
                                ) ?>

                                <span class="cart-item-count">
                                    <? Pjax::begin([
                                        'id' => 'cart-item-count',
                                        'enablePushState' => false,
                                        'timeout' => 5000,
                                        'options' => [
                                            'data-url' => '/cart/item-count',
                                        ]
                                    ]) ?>
                                    <?= Cart::getItemCount() ?>
                                    <? Pjax::end() ?>
                                </span>
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
    <section id="main" class="hero-area">
        <div class="container">

            <!-- Start Breadcrumbs -->
            <?php
            if (isset($this->params['breadcrumbs']) && !empty($this->params['breadcrumbs'])) { // Проверяем, есть ли breadcrumbs в параметрах
                $breadcrumbs = $this->params['breadcrumbs'];
                $lastItem = array_pop($breadcrumbs); // Извлекаем последний элемент (текущая страница)
            ?>
                <div class="breadcrumbs border rounded-4 my-3">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="breadcrumbs-content">
                                    <h3 class="page-title fs-4"><?= is_array($lastItem) ? $lastItem['label'] : $lastItem ?></h3>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 col-12">
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

            <!-- Preloader -->
            <!-- <div class="preloader">
                <div class="preloader-inner">
                    <div class="preloader-icon">
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div> -->
            <!-- /End Preloader -->

            <div class="mt-3"><?php echo Alert::widget() ?></div>

            <?= $content ?>

            <?php if (isset($this->blocks['additional'])): ?>
                <?= $this->blocks['additional'] ?> <!-- Секция для дополнительного контента -->
            <?php endif; ?>

            <?= \app\widgets\RecentlyViewed::widget() ?>
        </div>
    </section>
    <!-- End Hero Area -->

    <!-- Start Footer Area -->
    <footer class="footer mt-3">
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
                                    Подпишитесь на рассылку
                                    <span>Узнавайте первыми о новинках, скидках и многом другом</span>
                                </h4>
                                <div class="newsletter-form-head">
                                    <form action="#" method="get" target="_blank" class="newsletter-form">
                                        <input name="EMAIL" placeholder="Ваш e-mail адрес" type="email">
                                        <div class="button">
                                            <button class="btn">Подписаться<span class="dir-part"></span></button>
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
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-contact">
                                <h3>Как с нами связаться</h3>
                                <p class="phone">Телефон: +7(123)-456-78-90</p>
                                <ul>
                                    <li><span>Понедельник-Пятница: </span> 09:00 - 21.00 pm</li>
                                    <li><span>Суббота: </span> 10:00 - 20:00 pm</li>
                                </ul>
                                <p class="mail">proteinPioneerShop@yandex.ru</p>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Популярные категории</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Протеины</a></li>
                                    <li><a href="javascript:void(0)">Батончики</a></li>
                                    <li><a href="javascript:void(0)">Гейнеры</a></li>
                                    <li><a href="javascript:void(0)">Креатин</a></li>
                                    <li><a href="javascript:void(0)">Жирозжигатели</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-2 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Страницы</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Главная</a></li>
                                    <li><a href="javascript:void(0)">Каталог</a></li>
                                    <?php if (!Yii::$app->user->isGuest) : ?>
                                        <?php if (Yii::$app->user->identity->isAdmin) : ?>
                                            <li><a href="/admin-panel">Панель администратора</a></li>
                                        <?php else : ?>
                                            <li><a href="/personal">Личный кабинет</a></li>
                                            <li><a href="/personal/favourite-products">Избранное</a></li>
                                            <li><a href="/personal/compare-products">Сравнение товаров</a></li>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <li><a href="/site/login">Вход</a></li>
                                        <li><a href="/site/register">Регистрация</a></li>
                                    <?php endif; ?>
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
                                <span>Мы принимаем:</span>
                                <img src="/front/images/footer/credit-cards-footer.png" alt="#">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="copyright">
                                <p>Разработано by <span class="text-warning fw-bold" href="https://graygrids.com/" rel="nofollow"
                                        target="_blank">Javalets</span></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <ul class="socila">
                                <li>
                                    <span>Мы в соц.сетях:</span>
                                </li>
                                <li>
                                    <a href="#"><i class="lni lni-vk"></i></a>
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

    <?php if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) : ?>
        <?php Modal::begin([
            'id' => 'cart-modal',
            'size' => 'modal-lg',
            'title' => 'Корзина'
        ]); ?>

        <?php $cart_data = $this->render('@app/views/cart/index', ['dataProvider' => null]); ?>

        <div class="d-flex justify-content-end gap-3 my-2 d-none cart-panel-top">
            <div class="d-flex justify-content-end gap-3">
                <?= Html::a(
                    '<i class="bi bi-trash3"></i>',
                    ["/cart/clear"],
                    ["class" => "btn btn-danger btn-cart-clear"]
                ) ?>
                <?= Html::a(
                    "Перейти к оформлению",
                    ["/personal/orders/create"],
                    ["class" => "btn btn-orange"]
                ) ?>
            </div>
        </div>
        <?= $cart_data ?>
        <div class="d-flex justify-content-between gap-3 mt-2">
            <div class="d-flex justify-content-end">
                <?= Html::a(
                    '<i class="bi bi-trash3"></i>',
                    ["/cart/clear"],
                    ["class" => "btn btn-danger btn-cart-clear d-none btn-cart-manager"]
                ) ?>
                <?= Html::a(
                    "Перейти к оформлению",
                    ["/personal/orders/create"],
                    ["class" => "btn btn-orange d-none btn-cart-manager"]
                ) ?>
            </div>
        </div>
        <?php Modal::end(); ?>
        <?php $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]); ?>
    <?php endif; ?>

    <?php
    if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) {
        Modal::begin([
            'id' => 'info-modal',
            'size' => 'modal-md',
            'headerOptions' => [
                'class' => 'bg-secondary',
            ],
            'bodyOptions' => [
                'class' => 'bg-secondary',
            ],

        ]);
        echo "<div id='text-error' class='text-light'></div>";
        Modal::end();
        $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]);
    }
    ?>

    <?php $this->endBody() ?>
</body>

<?= Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin ? $this->registerJsFile("/front/js/bootstrap.min.js") : '' ?>
<?= $this->registerJsFile("/front/js/header.js") ?>

</html>
<?php $this->endPage() ?>