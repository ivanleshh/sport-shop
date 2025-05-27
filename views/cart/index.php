<?php

use app\models\Cart;
use app\models\Product;
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

    <?php Pjax::begin([
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
        <div class="d-flex gap-2 justify-content-end flex-wrap border-top border-bottom py-2 text-dark">
            <div>Количество товаров: <span class="fw-bold fs-5"><?= $cart->product_amount ?></span></div>
            <div>Общая сумма: <span class="fw-bold fs-5"><?= $cart->total_amount ?> ₽</span></div>
        </div>
    <?php else: ?>
        <div class="cart-empty">
            <div class="row position-relative justify-content-center text-center">
                <div class="position-absolute d-flex align-items-center bg-warning rounded-4 col-11 col-lg-6 p-2 bottom-0 fs-6">
                    <div class="text-danger fs-1">
                        <i class="bi bi-exclamation-lg"></i>
                    </div>
                    <div class="text-dark">
                        <span>Корзина пока что пустая. Вы можете добавить товары в
                            <?= Html::a('каталоге', ['/catalog'], ['class' => "text-uppercase text-danger", 'data-pjax' => 0]) ?>
                        </span>
                    </div>

                </div>
                <div class="col-7 col-sm-8 col-lg-5 mb-5 mb-sm-0">
                    <?= Html::img(Product::NOTHING_FIND, ['class' => 'rounded-circle']) ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php Pjax::end(); ?>
</div>