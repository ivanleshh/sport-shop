<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminPanelAsset;
use app\models\User;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AdminPanelAsset::register($this);

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


<body>
    <?php $this->beginBody() ?>
    <div class="container-scroller">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <h5 class="brand-logo ps-5 ps-lg-0 fs-6 mt-2 text-uppercase pe-4">Панель администратора</h5>
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav navbar-nav-right d-none d-lg-flex gap-3">
                    <li class="">
                        <div class="dropdown-header d-flex gap-3 align-items-center">
                            <img class="rounded-circle img-sm" src="<?= User::ADMIN_PHOTO ?>" alt="Profile image">
                            <div>
                                <span class="fw-bold"><?= Yii::$app->user->identity->nameSurname ?></span>
                                <p class="font-weight-light text-muted mb-0"><?= Yii::$app->user->identity->email ?></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <?= Html::beginForm(['/site/logout'])
                            . Html::submitButton(
                                'Выход <i class="bi bi-door-open-fill text-danger fs-6"></i>',
                                ['class' => 'logout bg-transparent border-0']
                            )
                            . Html::endForm()
                        ?>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item navbar-brand-mini-wrapper mt-4">
                        <a class="nav-link navbar-brand brand-logo-mini" href="/admin-panel"><i class="bi bi-person-badge-fill"></i></a>
                    </li>
                    <li class="nav-item nav-profile mt-4">
                        <a href="/admin-panel/orders" class="nav-link">
                            <div class="profile-image">
                                <img class="img-xs rounded-circle" src="<?= User::ADMIN_PHOTO ?>" alt="profile image">
                                <div class="dot-indicator bg-warning"></div>
                            </div>
                            <div class="text-wrapper">
                                <p class="profile-name"><?= Yii::$app->user->identity->nameSurname ?></p>
                                <p class="designation">Администратор</p>
                            </div>
                            <i class="bi bi-person-badge-fill"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-category"><span class="nav-link">Управление магазином</span></li>
                    <li class="nav-item active">
                        <div class="nav-link">
                            <span class="menu-title">Опции</span>
                            <i class="bi bi-stack menu-icon"></i>
                        </div>
                        <div class="collapse active show" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/admin-panel/orders">Заказы</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin-panel/product">Товары</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin-panel/category">Категории</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin-panel/brand">Бренды</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <?= Html::beginForm(['/site/logout'])
                            . Html::submitButton(
                                '<span class="menu-title">Выход</span><i class="bi bi-door-open-fill"></i>',
                                ['class' => 'nav-link logout bg-transparent border-0 text-muted w-100 text-center']
                            )
                            . Html::endForm()
                        ?>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <?php
                            if (isset($this->params['breadcrumbs']) && !empty($this->params['breadcrumbs'])) { // Проверяем, есть ли breadcrumbs в параметрах
                                $breadcrumbs = $this->params['breadcrumbs'];
                                $lastItem = array_pop($breadcrumbs); // Извлекаем последний элемент (текущая страница)
                            ?>
                                <div class="breadcrumbs border rounded-4 mb-3">
                                    <div class="container-admin">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="breadcrumbs-content">
                                                    <h3 class="page-title fs-4"><?= is_array($lastItem) ? $lastItem['label'] : $lastItem ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <ul class="breadcrumb-nav p-0 m-0 mt-1 mt-md-0">
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
                            <?= Alert::widget() ?>
                            <?= $content ?>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 Stellar. All rights reserved. <a href="#"> Terms of use</a><a href="#">Privacy Policy</a></span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="icon-heart text-danger"></i></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>