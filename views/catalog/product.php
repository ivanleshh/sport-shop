<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card rounded-3" style="width: 18rem; height: 29rem;">
  <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin) : ?>
    <div class="d-flex justify-content-end w-100 bg-dark bg-gradient rounded-top-2 px-3 py-2 gap-3">
      <?= Html::a('сравнить', [''], ['class' => 'card-different text-decoration-none link-light']) ?>
      <?= Html::a(
        "<i class='bi bi-suit-heart-fill " . (empty($model->favouriteProducts[0]->status) ? 'text-light' : 'text-danger') . "'></i>",
        ['favourite'],
        ['data-id' => $model->id, 'class' => 'btn-favourite text-decoration-none align-self-end']
      ) ?>
    </div>
  <?php endif; ?>
  <div class="card-body d-flex justify-content-between flex-column">
    <div class="card-img d-flex justify-content-center align-items-center border-bottom h-100">
      <?= Html::a(
        Html::img(isset($model->productImages[0]->photo) ? Product::IMG_PATH . $model->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'card-img-product']),
        ['/product/view', 'id' => $model->id],
        ['class' => 'd-flex flex-column align-items-center']
      ) ?>
    </div>
    <div class="d-flex flex-column gap-2">
      <span class="text-secondary mt-2"><?= $model->category->title ?></span>
      <h5 class="card-body-title"><?= $model->title ?></h5>
      <p class="card-text fw-bold fs-6 mb-2"><?= $model->price ?> ₽</p>

      <?php if (isset($model->cartItems[0])) : ?>
        <div class="d-flex align-items-center justify-content-center gap-4">
          <?= Html::a('Оформить', ['/personal/orders/create'], ['class' => 'btn btn-orange']) ?>
          <div class="d-flex gap-3 align-items-center">
            <?= Html::a(
              '-',
              ['cart/dec-item', 'item_id' => $model->cartItems[0]->id],
              ['class' => 'btn btn-outline-warning btn-cart-item-dec text-dark']
            ) ?>
            <?= $model->cartItems[0]->product_amount ?>
            <?= Html::a(
              '+',
              ['cart/inc-item', 'item_id' => $model->cartItems[0]->id],
              ['class' => 'btn btn-outline-warning btn-cart-item-inc text-dark']
            ) ?>
          </div>
        </div>
      <?php else : ?>
        <?= ! Yii::$app->user->isGuest && ! Yii::$app->user->identity->isAdmin
          ? Html::a(
            'В корзину',
            ['cart/add', 'product_id' => $model->id],
            ['class' => 'btn-cart-add btn btn-warning w-100']
          ) : ""
        ?>
      <?php endif; ?>

    </div>
  </div>
</div>