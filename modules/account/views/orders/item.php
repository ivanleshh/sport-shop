<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card d-flex gap-3 <?= $model->product_amount > $model->product->count ? 'border border-danger' : '' ?>">
    <div class="card-body">
        <div class="row justify-content-between align-items-center">
            <div class="col-3 col-xl-2 d-none d-sm-block">
                <?= Html::img(isset($model->product->productImages[0]->photo) ? Product::IMG_PATH . $model->product->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'img-cart_product w-100']) ?>
            </div>
            <div class="col-5 col-sm-4 col-md-5 d-flex flex-column gap-1">
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
            </div>
            <div class="col-5 col-sm-4 col-md-3 d-flex justify-content-center align-items-center flex-column gap-2">
                <div class="d-flex gap-3 align-items-center">
                    <?= Html::a(
                        '-',
                        ['/cart/dec-item', 'item_id' => $model->id],
                        ['class' => 'btn btn-outline-danger btn-cart-item-dec']
                    ) ?>
                    <?= $model->product_amount ?>
                    <?= Html::a(
                        '+',
                        ['/cart/inc-item', 'item_id' => $model->id],
                        ['class' => 'btn btn-outline-success btn-cart-item-inc']
                    ) ?>
                </div>
                <div>
                    <?= $model->total_amount ?> ₽
                </div>
            </div>
            <div class="col-2 col-sm-1 align-self-start text-end">
                <?= Html::a('<i class="bi bi-trash3"></i>',
                    ['/cart/remove-item', 'item_id' => $model->id],
                    ['class' => 'fs-5 text-danger btn-cart-item-remove']
                ) ?>
            </div>
        </div>
    </div>
</div>