<?php

use app\widgets\Alert;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\widgets\PjaxAsset;

PjaxAsset::register($this);

/** @var yii\web\View $this */
/** @var app\modules\adminPanel\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'] = [
    ['label' => 'Панель администратора', 'url' => ['/admin-panel'], 'icon' => 'bi bi-house-fill mx-2'],
    'Управление товарами',
];
?>
<div class="product-index hero-content">

    <?= Alert::widget(); ?>

    <?php Pjax::begin([
        'id' => 'product-index-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <div class="row justify-content-between align-items-center">
        <div class="col-12 col-xxl-9">
            <?= $this->render('_search', [
                'model' => $searchModel,
            ]) ?>
        </div>
        <div class="col-12 col-xxl-3 d-flex gap-3 justify-content-end flex-wrap">
            Сортировать по:
            <?= $dataProvider->sort->link('price', ['class' => 'text-decoration-none']) ?>
            <?= $dataProvider->sort->link('count', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('Сбросить', ['/admin-panel/product'], ['class' => 'text-decoration-none link-danger']) ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-12 col-sm-6 col-lg-6 col-xl-4 col-xxl-3'],
        'pager' => [
            'class' => LinkPager::class,
        ],
        'layout' =>
        '<div class="text-center mt-3">{pager}</div>
            <div class="row gy-4">{items}</div>
            <div class="text-center mt-3">{pager}</div>',
        'itemView' => 'item',
    ]) ?>

    <?php Pjax::end() ?>

</div>

<?php
Modal::begin([
    'id' => 'product-delete',
    'title' => '',
    'size' => 'modal-md',
]);
?>
<div class="d-flex justify-content-end gap-3 my-2 cart-panel-top">
    <div class="d-flex justify-content-end gap-3">
        <?= Html::a(
            'Удалить',
            ["success"],
            ["class" => "btn btn-danger btn-agree", 'data-pjx' => '#product-index-pjax']
        ) ?>
        <?= Html::a(
            "Назад",
            '',
            ["class" => "btn btn-secondary btn-disagree"]
        ) ?>
    </div>
</div>
<?php
Modal::end();
?>

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/filter-product.js', ['depends' => JqueryAsset::class]) ?>
<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/product-delete.js', ['depends' => JqueryAsset::class]) ?>