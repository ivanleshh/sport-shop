<?php

use app\models\Orders;
use app\widgets\Alert;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
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
    ['label' => 'Панель администратора', 'url' => ['/admin-panel'], 'icon' => 'bi bi-house-fill mx-2'],
    'Модерация заказов',
];
?>
<div class="orders-index hero-content">

    <?php Pjax::begin([
        'id' => 'admin-orders-pjax',
        'enablePushState' => false,
        'enableReplaceState' => false,
        'timeout' => 5000,
    ]); ?>

    <div class="row justify-content-between align-items-center">
        <div class="col-12 col-xxl-9">
            <?= $this->render('_search', [
                'model' => $searchModel,
                'pickUps' => $pickUps,
                'statuses' => $statuses,
            ]) ?>
        </div>
        <div class="col-12 col-xxl-3 d-flex gap-3 justify-content-end flex-wrap">
            Сортировать по:
            <div>
                <?= $dataProvider->sort->link('created_at', ['class' => 'text-decoration-none pe-3', 'data-pjax' => 1]) ?>
                <?= Html::a('Сбросить', ['/admin-panel/orders'], ['class' => 'text-decoration-none link-danger']) ?>
            </div>

        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-12 col-xxl-6'],
        'pager' => [
            'class' => LinkPager::class,
        ],
        'layout' =>
        '<div class="text-center mt-3">{pager}</div>
            <div class="row gy-4">{items}</div>
            <div class="text-center mt-3">{pager}</div>',
        'itemView' => 'order',
    ]) ?>

    <?php Pjax::end(); ?>

</div>

<?php
if ($dataProvider->count) {
    Modal::begin([
        'id' => 'orders-delay-modal',
        'title' => 'Уведомление о задержке доставки',
        'size' => 'modal-md',
    ]);
    echo $this->render('delay', compact('model_delay'));
    Modal::end();
    $this->registerJsFile('/admin-panel-dist/assets/js-my/orders-delay.js', ['depends' => JqueryAsset::class]);
}
?>

<?php
Modal::begin([
    'id' => 'orders-actions',
    'title' => '',
    'size' => 'modal-md',
]);
?>
<div class="d-flex justify-content-end gap-3 my-2 cart-panel-top">
    <div class="d-flex justify-content-end gap-3">
        <?= Html::a(
            'Подтвердить',
            ["success"],
            ["class" => "btn btn-success btn-agree", 'data-pjx' => '#admin-orders-pjax']
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

<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/filter-order.js', ['depends' => JqueryAsset::class]) ?>
<?= $this->registerJsFile('/admin-panel-dist/assets/js-my/order-buttons.js', ['depends' => JqueryAsset::class]) ?>