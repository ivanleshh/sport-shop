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

$this->params['breadcrumbs'] = [
    ['label' => 'Главная', 'url' => ['/site'], 'icon' => 'bi bi-house-fill mx-2'],
    'Оформление заказа',
];
?>

<div class="create-order hero-content m-0 row">
    <div class="create-order-cart col-12 col-lg-7 order-2 order-lg-1 mt-4 mt-lg-0">
        <div class="row mt-lg-0 align-items-center">
            <h3 class="col-9 col-sm-6 fs-5">Состав заказа</h3>
            <div class="col-3 col-sm-6 text-end">
                <?= Html::a(
                    "Очистить корзину",
                    ["/cart/clear"],
                    ["class" => "text-danger text-decoration-none btn-cart-clear"]
                ) ?>
            </div>
        </div>

        <?php Pjax::begin([
            'id' => 'order-pjax',
            'enablePushState' => false,
            'timeout' => 5000,
        ]);
        ?>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => 'item',
            'pager' => [
                'class' => LinkPager::class
            ],
            'layout' => "<div class='d-flex justify-content-center'>{pager}</div>
                <div class='d-flex flex-column gap-3 my-3'>{items}</div>
                <div class='d-flex justify-content-center'>{pager}</div>"
        ]) ?>
        <div class="d-flex justify-content-between flex-wrap border-top border-bottom py-2 my-2 text-dark gap-3">
            <a class="text-decoration-none mt-1 text-danger" href="/"><- Вернуться к покупкам</a>
                    <div>Позиций в корзине: <span class="fw-bold fs-5"><?= $cart->product_amount ?></span></div>
                    <div>Общая сумма: <span class="fw-bold fs-5"><?= $cart->total_amount ?> ₽</span></div>
        </div>

        <?php Pjax::end(); ?>
    </div>
    <div class="create-order-form col-12 col-lg-5 order-1 order-lg-2">
        <h3 class="mb-3 fs-5">Данные заказа</h3>
        <?= $this->render('_form', [
            'model' => $model,
            'typePays' => $typePays,
            'pickUps' => $pickUps,
        ]) ?>
    </div>
</div>

<?php $this->registerJsFile('/js/order.js', ['depends' => JqueryAsset::class]); ?>