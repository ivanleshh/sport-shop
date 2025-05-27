<?php

use app\models\Orders;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\account\models\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    ['label' => 'Личный кабинет', 'url' => ['/personal']],
    'Мои заказы',
];
?>
<div class="orders-index hero-content">

    <?php Pjax::begin([
        'id' => 'personal-orders-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
        'enableReplaceState' => false,
    ]); ?>

    <div class="row gy-3 justify-content-between align-items-center">
        <div class="col-12 col-xxl-8">
            <?= $this->render('_search', [
                'model' => $searchModel,
                'pickUps' => $pickUps,
                'statuses' => $statuses,
            ]) ?>
        </div>
        <div class="col-12 col-xxl-4 d-flex gap-3 justify-content-end flex-wrap">
            Сортировать по:
            <div>
                <?= $dataProvider->sort->link('created_at', ['class' => 'text-decoration-none pe-3', 'data-pjax' => 1]) ?>
                <?= Html::a('Сбросить', ['/personal/orders'], ['class' => 'text-decoration-none link-danger']) ?>
            </div>

        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-12 col-lg-6 col-xl-4'],
        'pager' => [
            'class' => LinkPager::class,
        ],
        'layout' =>
        '<div class="d-flex mt-3">{pager}</div>
            <div class="row gy-4">{items}</div>
            <div class="d-flex mt-3">{pager}</div>',
        'itemView' => 'order',
    ]) ?>

    <?php Pjax::end(); ?>

</div>

<?= \app\widgets\RecentlyViewed::widget() ?>

<?= $this->registerJsFile('/js/filter-order.js', ['depends' => JqueryAsset::class]) ?>