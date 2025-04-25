<?php

use app\models\Product;
use coderius\swiperslider\SwiperSlider;
use yii\bootstrap5\Html;
?>
<div class="card rounded-3" style="width: 18rem; height: 29rem;">

  <div class="d-flex rounded-top align-items-center justify-content-end w-100 rounded-top-2 px-3 pt-2 gap-3">

    <?= Html::a(
      '<i class="bi bi-trash3-fill text-danger fs-6"></i>',
      ['index', 'id' => $model->id],
      ['data' => ['id' => $model->id, 'pjax' => 0], 'class' => 'btn-favourite text-decoration-none align-self-end']
    ) ?>
  </div>

  <div class="card-body d-flex justify-content-between flex-column">

    <?php if (count($model->product->productImages) > 1) : ?>
      <?= SwiperSlider::widget([
        'showPagination' => false,
        'slides' => array_map(
          fn($image) =>
          '<div class="card-img d-flex justify-content-center align-items-center h-100">' .
            Html::a(
              Html::img(
                isset($image->photo) ? Product::IMG_PATH . $image->photo : Product::NO_PHOTO,
                ['class' => 'card-img-product']
              ),
              ['/product/view', 'id' => $model->product->id],
              ['class' => 'd-flex flex-column align-items-center']
            ) . '</div>',
          $model->product->productImages
        ),
        'clientOptions' => [
          'pagination' => [
            'clickable' => true,
          ],
        ],
        'options' => [
          'styles' => [
            \coderius\swiperslider\SwiperSlider::CONTAINER => ["width" => "100%"],
            \coderius\swiperslider\SwiperSlider::BUTTON_NEXT => ["color" => "lightgray", 'right' => 0],
            \coderius\swiperslider\SwiperSlider::BUTTON_PREV => ["color" => "lightgray", 'left' => 0],
          ],
        ],
      ]); ?>
    <?php else : ?>
      <div class="card-img d-flex justify-content-center align-items-center h-100">
        <?= Html::a(
          Html::img(isset($model->product->productImages[0]->photo) ? Product::IMG_PATH . $model->product->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'card-img-product']),
          ['/product/view', 'id' => $model->product->id],
          ['class' => 'd-flex flex-column align-items-center']
        ) ?>
      </div>
    <?php endif; ?>

    <div class="d-flex flex-column gap-2 border-top">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <span class="text-secondary"><?= $model->product->category->title ?></span>
        <div>
          <?php
          $isCompare = !empty($model->product->compareProducts[0]->status);
          echo Html::a(
            $isCompare ? "в сравнении" : "сравнить",
            ['/catalog/compare'],
            ['data-id' => $model->product->id, 'class' => "btn-compare btn btn-sm " . ($isCompare ? "btn-secondary" : "btn-outline-secondary") . " text-decoration-none"]
          ) ?>
        </div>
      </div>
      <span class="fs-6 text-dark"><?= $model->product->title ?></span>

      <span class="card-text text-dark fw-bold fs-6"><?= $model->product->price ?> ₽</span>

      <?php if (isset($model->product->cartItems[0])) : ?>
        <div class="d-flex align-items-center gap-3">
          <div class="w-100">
            <?= Html::a('Оформить', ['/personal/orders/create'], ['class' => 'btn btn-orange w-100']) ?>
          </div>
          <div>
            <?= Html::a(
              '-',
              ['/cart/dec-item', 'item_id' => $model->product->cartItems[0]->id],
              ['class' => 'btn btn-outline-secondary btn-cart-item-dec']
            ) ?>
          </div>
          <div>
            <?= $model->product->cartItems[0]->product_amount ?>
          </div>
          <div>
            <?= Html::a(
              '+',
              ['/cart/inc-item', 'item_id' => $model->product->cartItems[0]->id],
              ['class' => 'btn btn-outline-secondary btn-cart-item-inc']
            ) ?>
          </div>
        </div>
      <?php else : ?>
        <?= ! Yii::$app->user->isGuest && ! Yii::$app->user->identity->isAdmin
          ? Html::a(
            'В корзину',
            ['/cart/add', 'product_id' => $model->product->id],
            ['class' => 'btn-cart-add btn btn-warning w-100']
          ) : ""
        ?>
      <?php endif; ?>

    </div>
  </div>
</div>