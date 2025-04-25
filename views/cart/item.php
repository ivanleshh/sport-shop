<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card">
    <div class="card-body">
        <div class="row justify-content-between align-items-center">
            <div class="col-6 col-sm-7">
                <div class="row justify-content-center align-items-center gy-2">
                    <div class="col-8 col-sm-4 col-xl-3 text-center">
                        <?= Html::a(
                            Html::img(isset($model->product->productImages[0]->photo) ? Product::IMG_PATH . $model->product->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'img-cart_product w-100']),
                            ['/product/view', 'id' => $model->product->id, 'data-pjax' => 0]
                        ) ?>
                    </div>
                    <div class="col-12 col-sm-7 text-center">
                        <h6 class="card-title mb-1">
                            <?= Html::a(
                                $model->product->title,
                                ['/product/view', 'id' => $model->product_id],
                                ['data-pjax' => 0]
                            ) ?>
                        </h6>
                        <div>
                            <?= $model->product->price ?> ₽
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 d-flex align-items-center flex-column gap-2">
                <div class="d-flex gap-3 align-items-center">
                    <?= Html::a(
                        '-',
                        ['cart/dec-item', 'item_id' => $model->id],
                        ['class' => 'btn btn-outline-secondary btn-cart-item-dec']
                    ) ?>
                    <?= $model->product_amount ?>
                    <?= Html::a(
                        '+',
                        ['cart/inc-item', 'item_id' => $model->id],
                        ['class' => 'btn btn-outline-secondary btn-cart-item-inc']
                    ) ?>
                </div>
                <div class="text-center fw-bold">
                    Итого: <?= $model->total_amount ?> ₽
                </div>
            </div>
            <div class="col-2 col-sm-1 align-self-start text-end">
                <?= Html::a(
                    '<i class="bi bi-trash3"></i>',
                    ['cart/remove-item', 'item_id' => $model->id],
                    ['class' => 'btn-cart-item-remove text-danger fs-5']
                ) ?>
            </div>
        </div>
    </div>
</div>