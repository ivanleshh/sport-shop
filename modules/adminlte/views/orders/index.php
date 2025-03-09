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

$this->title = 'Модерация заказов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php Pjax::begin([
        'id' => 'admin-orders-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

    <?php if (Yii::$app->session->hasFlash('order-delay')) {
        Yii::$app->session->setFlash('info', Yii::$app->session->getFlash('order-delay'));
        Yii::$app->session->removeFlash('order-delay');
        echo Alert::widget();
    }
    ?>

    <div class="d-flex align-items-center justify-content-between gap-5">
        <div class="d-flex gap-3">
            Сортировать по:
            <?= $dataProvider->sort->link('created_at', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('Сбросить', ['/admin-lte/orders'], ['class' => 'text-decoration-none link-dark']) ?>
        </div>
        <div class="d-flex">
            <?= $this->render('_search', [
                'model' => $searchModel,
                'pickUps' => $pickUps,
                'statuses' => $statuses,
            ]) ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item col-12 col-xxl-6'],
        'pager' => [
            'class' => LinkPager::class,
        ],
        'layout' => 
            '<div class="d-flex mt-3">{pager}</div>
            <div class="row">{items}</div>
            <div class="d-flex mt-3">{pager}</div>',
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
    $this->registerJsFile('/js/orders-delay.js', ['depends' => JqueryAsset::class]);
}
?>

<?= $this->registerJsFile('/admin-lte-dist/js/filter-order.js', ['depends' => JqueryAsset::class]) ?>



