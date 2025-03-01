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

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Каталог', 'url' => ['/catalog']],
                !Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin ? ['label' => 'Личный кабинет', 'url' => ['/personal']] : '',
                Yii::$app->user->isGuest ? ['label' => 'Регистрация', 'url' => ['/site/register']] : '',
                Yii::$app->user->isGuest
                    ? ['label' => 'Вход', 'url' => ['/site/login']]
                    : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Выход (' . Yii::$app->user->identity->login . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ]
        ]);
        ?>

        <?php if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) : ?>
            <div class="d-flex ms-5 gap-2 text-white">
                <?= Html::a(
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" 
            class="bi bi-cart-fill" viewBox="0 0 16 16"><path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 
            .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 
            3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 
            0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>',
                    ['/cart/index'],
                    ['id' => 'btn-cart']
                ) ?>
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
            </div>
        <?php endif; ?>
        <?php NavBar::end(); ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>

    <?php if (!(Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin)) : ?>
        <?php Modal::begin([
            'id' => 'cart-modal',
            'size' => 'modal-lg',
            'title' => 'Корзина'
        ]); ?>

        <?php $cart_data = $this->render('@app/views/cart/index', ['dataProvider' => null]); ?>

        <div class="d-flex justify-content-between gap-3 my-2 d-none cart-panel-top">
            <div>
                <?= Html::a(
                    "Закрыть",
                    "",
                    ["class" => "btn btn-outline-secondary btn-cart-close"]
                ) ?>
            </div>
            <div class="d-flex justify-content-end gap-3">
                <?= Html::a(
                    "Очистить корзину",
                    ["/cart/clear"],
                    ["class" => "btn btn-outline-danger btn-cart-clear"]
                ) ?>
                <?= Html::a(
                    "Оформить заказ",
                    ["/personal/orders/create"],
                    ["class" => "btn btn-outline-success"]
                ) ?>
            </div>
        </div>
        <?= $cart_data ?>
        <div class="d-flex justify-content-between gap-3 mt-2">
            <div class="d-flex justify-content-end">
                <?= Html::a(
                    "Очистить корзину",
                    ["/cart/clear"],
                    ["class" => "btn btn-outline-danger btn-cart-clear d-none btn-cart-manager"]
                ) ?>
                <?= Html::a(
                    "Оформить заказ",
                    ["/personal/orders/create"],
                    ["class" => "btn btn-outline-success d-none btn-cart-manager"]
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
        ]);
        echo "<div id='text-error'></div>";
        Modal::end();
        $this->registerJsFile('/js/cart.js', ['depends' => JqueryAsset::class]);
    }
    ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
