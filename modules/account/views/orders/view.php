<?php

use app\models\Cart;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\helpers\VarDumper;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['cart-data'] = $dataProvider && $dataProvider->totalCount;
?>
<div class="cart-index">
    <h3>Заказ № <?= $model->id ?> от <?= Yii::$app->formatter->asDate($model->created_at, 'php:d-m-Y') ?> 
    (<?= Yii::$app->formatter->asTime($model->created_at, 'php:H:i') ?>)</h3>
    <p>Состав заказа:</p>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'order-item',
        'pager' => [
            'class' => LinkPager::class
        ],
        'layout' => "<div class='d-flex flex-column gap-3 my-3'>{items}</div>\n{pager}"
    ]) ?>
    <div class="d-flex gap-1 align-items-end flex-column border-top border-bottom">
        <div>Количество товаров в заказе:<span class="fw-bold fs-5"><?= $model->product_amount ?></span></div>
        <div>Общая сумма заказа:<span class="fw-bold fs-5"><?= $model->total_amount ?></span></div>
    </div>
</div>