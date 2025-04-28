<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card <?= $model->product_amount > $model->product->count ? 'border border-danger' : '' ?>">
    <div class="card-body">
        <div class="row justify-content-between align-items-center gy-3">
            <div class="col-5 col-md-7 d-flex flex-column align-items-center flex-sm-row gap-3">
                <div class="col-10 col-sm-8 col-md-4 col-lg-3">
                    <?= Html::a(
                        Html::img(isset($model->product->productImages[0]->photo) ? Product::IMG_PATH . $model->product->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'img-cart_product w-100']),
                        ['/product/view', 'id' => $model->product->id],
                        ['data-pjax' => 0],
                    ) ?>
                </div>
                <div class="col-12 col-md-8 col-lg-9 d-none d-md-block text-center">
                    <h6 class="card-title">
                        <?= Html::a(
                            $model->product->title,
                            ['/product/view', 'id' => $model->product_id],
                            ['data-pjax' => 0, 'class' => 'text-dark link-danger']
                        ) ?>
                    </h6>
                    <div>
                        <?= $model->product->price ?> ₽
                    </div>
                </div>
            </div>

            <div class="col-5 col-md-4 d-flex justify-content-center align-items-center flex-column gap-2">
                <div class="d-flex gap-3 align-items-center">
                    <?= Html::a(
                        '-',
                        ['/cart/dec-item', 'item_id' => $model->id],
                        ['class' => 'btn btn-outline-secondary btn-cart-item-dec']
                    ) ?>
                    <?= $model->product_amount ?>
                    <?= Html::a(
                        '+',
                        ['/cart/inc-item', 'item_id' => $model->id],
                        ['class' => 'btn btn-outline-secondary btn-cart-item-inc']
                    ) ?>
                </div>
                <div class="fw-bold">
                    <?= $model->total_amount ?> ₽
                </div>
            </div>

            <div class="col-2 col-md-1 align-self-start text-end">
                <?= Html::a(
                    '<i class="bi bi-trash3"></i>',
                    ['/cart/remove-item', 'item_id' => $model->id],
                    ['class' => 'fs-5 text-danger btn-cart-item-remove']
                ) ?>
            </div>

            <div class="col-12 gap-3 d-flex justify-content-between d-md-none">
                <h6 class="card-title">
                    <?= Html::a(
                        $model->product->title,
                        ['/product/view', 'id' => $model->product_id],
                        ['data-pjax' => 0, 'class' => 'text-dark link-danger']
                    ) ?>
                </h6>
                <div class="text-nowrap">
                    <?= $model->product->price ?> ₽
                </div>
            </div>
        </div>
    </div>
</div>