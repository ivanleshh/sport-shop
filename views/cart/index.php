<?php

use app\models\Cart;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->params['cart-data'] = $dataProvider && $dataProvider->totalCount;
?>
<div class="cart-index">
    <?php
    Pjax::begin([
        'id' => 'cart-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]);
    ?>
    <?php if ($dataProvider && $dataProvider->totalCount) : ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => 'item',
            'pager' => ['class' => LinkPager::class],
            'layout' => "<div class='d-flex flex-column gap-3 my-3'>{items}</div>\n{pager}"
        ]) ?>
        <div class="d-flex gap-1 align-items-end flex-column border-top border-bottom py-2">
            <div>Количество товаров в корзине: <span class="fw-bold fs-5"><?= $cart->product_amount ?></span></div>
            <div>Общая сумма: <span class="fw-bold fs-5"><?= $cart->total_amount ?></span></div>
        </div>
    <?php else: ?>
        <div class="cart-empty">
            <div class="cart-empty-wrapper d-flex justify-content-center mt-5">
                <div class="d-flex flex-column justify-content-center align-items-center gap-1">
                    <h3>Корзина пустая</h3>
                    <div class="d-flex gap-1">
                        <span>Чтобы добавить товары вы можете</span>
                        <?= Html::a('вернуться в каталог', ['/'], ['class' => 'text-decoration-none', 'data-pjax' => 0]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php Pjax::end(); ?>
</div>