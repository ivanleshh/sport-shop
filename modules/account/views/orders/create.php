<?php

use app\models\Cart;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>

<?php if ($dataProvider && $dataProvider->totalCount) : ?>

    <div class="create-order d-flex gap-4">
        <div class="create-order-cart border rounded-3 px-4 py-3 w-50">
            <h3>Состав заказа</h3>

            <?php Pjax::begin([
                'id' => 'order-pjax',
                'enablePushState' => false,
                'timeout' => 5000,
            ]);
            ?>

            <div class="d-flex justify-content-end">
                <?= Html::a(
                    "Очистить корзину",
                    ["/cart/clear"],
                    ["class" => "text-danger text-decoration-none btn-cart-clear"]
                ) ?>
            </div>

            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => 'item',
                'pager' => [
                    'class' => LinkPager::class
                ],
                'layout' => "<div class='d-flex flex-column gap-3 my-2'>{items}</div>\n<div class='d-flex justify-content-end'>{pager}</div>"
            ]) ?>
            <div class="d-flex gap-1 align-items-end flex-column border-bottom py-2">
                <div>Позиций в корзине: <span class="fw-bold fs-5"><?= $cart->product_amount ?></span></div>
                <div>Общая сумма: <span class="fw-bold fs-5"><?= $cart->total_amount ?> ₽</span></div>
                <a class="text-decoration-none align-self-start" href="/"><- Вернуться к покупкам</a>
            </div>

            <?php Pjax::end(); ?>
        </div>
        <div class="create-order-form border rounded-3 px-4 py-3">
            <h3>Оформление заказа</h3>
            <?= $this->render('_form', [
                'model' => $model,
                'typePays' => $typePays,
                'pickUps' => $pickUps,
            ]) ?>
        </div>
    </div>

<?php else: ?>

    <div class="cart-empty">
        <div class="cart-empty-wrapper d-flex justify-content-center mt-5">
            <div class="d-flex flex-column justify-content-center align-items-center gap-1">
                <h3>Корзина пустая</h3>
                <div class="d-flex gap-1">
                    <span>Чтобы добавить товары вы можете</span>
                    <a class="text-decoration-none" href="/">вернуться в каталог</a>
                </div>

            </div>

        </div>

    </div>

<?php endif; ?>

<?php $this->registerJsFile('/js/order.js', ['depends' => JqueryAsset::class]); ?>