<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminPanelAsset;
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
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <ul class="navbar-nav navbar-nav-right">
                    <form class="search-form d-none d-md-block" action="#">
                        <i class="icon-magnifier"></i>
                        <input type="search" class="form-control" placeholder="Search Here" title="Search here">
                    </form>
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator message-dropdown" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon-speech"></i>
                            <span class="count">7</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                            <a class="dropdown-item py-3">
                                <p class="mb-0 font-weight-medium float-start me-2">You have 7 unread mails </p>
                                <span class="badge badge-pill badge-primary float-end">View all</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="/admin-panel-dist/assets/images/faces/face10.jpg" alt="image" class="img-sm profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">Marian Garner </p>
                                    <p class="font-weight-light small-text"> The meeting is cancelled </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="/admin-panel-dist/assets/images/faces/face12.jpg" alt="image" class="img-sm profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">David Grey </p>
                                    <p class="font-weight-light small-text"> The meeting is cancelled </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="/admin-panel-dist/assets/images/faces/face1.jpg" alt="image" class="img-sm profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow py-2">
                                    <p class="preview-subject ellipsis font-weight-medium text-dark">Travis Jenkins </p>
                                    <p class="font-weight-light small-text"> The meeting is cancelled </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
                        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="img-xs rounded-circle ms-2" src="/admin-panel-dist/assets/images/faces/face8.jpg" alt="Profile image"> <span class="font-weight-normal"> Henry Klein </span></a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle" src="/admin-panel-dist/assets/images/faces/face8.jpg" alt="Profile image">
                                <p class="mb-1 mt-3">Henry Klein</p>
                                <p class="font-weight-light text-muted mb-0">kleinhenry@gmail.com</p>
                            </div>
                            <a class="dropdown-item"><i class="bi bi-person-bounding-box"></i>Личный кабинет</a>
                            <a class="dropdown-item"><i class="dropdown-item-icon icon-speech text-primary"></i> Messages</a>
                            <a class="dropdown-item"><i class="dropdown-item-icon icon-energy text-primary"></i> Activity</a>
                            <a class="dropdown-item"><i class="dropdown-item-icon icon-question text-primary"></i> FAQ</a>
                            <a class="dropdown-item"><i class="dropdown-item-icon icon-power text-primary"></i>Sign Out</a>
                        </div>
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
                        <a href="/admin-panel" class="nav-link">
                            <div class="profile-image">
                                <img class="img-xs rounded-circle" src="/admin-panel-dist/assets/images/faces/face8.jpg" alt="profile image">
                                <div class="dot-indicator bg-warning"></div>
                            </div>
                            <div class="text-wrapper">
                                <p class="profile-name">Henry Klein</p>
                                <p class="designation">Администратор</p>
                            </div>
                            <i class="bi bi-person-badge-fill"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-category"><span class="nav-link">Управление магазином</span></li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <span class="menu-title">Опции</span>
                            <i class="bi bi-stack menu-icon"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/admin-panel/orders">Заказы</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin-panel/product">Товары</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin-panel/category">Категории</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin-panel/brand">Бренды</a></li>
                            </ul>
                        </div>
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
                                <div class="breadcrumbs border rounded-4 mb-4">
                                    <div class="container-admin">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="breadcrumbs-content">
                                                    <h3 class="page-title fs-4"><?= is_array($lastItem) ? $lastItem['label'] : $lastItem ?></h3>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <ul class="breadcrumb-nav p-0 m-0 mt-2 mt-lg-0">
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

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <? #= Alert::widget() 
            ?>
            <? #= $content 
            ?>
        </div>
    </main>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>