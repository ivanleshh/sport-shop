<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card">
    <div class="card-body">
        <div class="d-flex gap-2 justify-content-between align-items-center">
            <div class="w-10">
                <?= Html::img(Product::IMG_PATH . $model->product->productImages[0]->photo, ['class' => 'img-cart_product w-100']) ?>
            </div>
            <div class="d-flex flex-column gap-1">
                <h6 class="card-title">
                    <?= Html::a(
                        $model->product->title,
                        ['/product/view', 'id' => $model->product_id],
                        ['data-pjax' => 0]
                    ) ?>
                </h6>
                <div class="fw-bold">
                    <?= $model->product->price ?> ₽
                </div>
                <span>Осталось <?= $model->product->count ?> шт.</span>
            </div>
            <div class="d-flex justify-content-center flex-column gap-2">
                <div class="d-flex gap-3 align-items-center">
                    <?= Html::a(
                        '-',
                        ['cart/dec-item', 'item_id' => $model->id],
                        ['class' => 'btn btn-outline-danger btn-cart-item-dec']
                    ) ?>
                    <?= $model->product_amount ?>
                    <?= Html::a(
                        '+',
                        ['cart/inc-item', 'item_id' => $model->id],
                        ['class' => 'btn btn-outline-success btn-cart-item-inc']
                    ) ?>
                </div>
                <div>
                    Итого: <?= $model->total_amount ?> ₽
                </div>
            </div>
            <div class="align-self-start">
                <?= Html::a(
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 
            0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 
            1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 
            0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/></svg>',
                    ['cart/remove-item', 'item_id' => $model->id],
                    ['class' => 'btn btn-outline-danger btn-cart-item-remove']
                ) ?>
            </div>
        </div>
    </div>
</div>