<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card" style="width: 18rem; height: 28rem;">
  <div class="d-flex justify-content-between bg-dark w-100 bg-gradient rounded-top-2 px-3 py-2">
    <?= Html::a('+ В сравнение', [''], ['class' => 'text-decoration-none link-light']) ?>
    <?= Html::a('🤍', [''], ['class' => 'text-decoration-none align-self-end']) ?>
  </div>
  <div class="card-body d-flex justify-content-between flex-column">
    <div class="card-img d-flex justify-content-center align-items-center border-bottom h-100">
      <?= Html::a(
        Html::img(Product::IMG_PATH . $model->photo, ['class' => 'w-100']),
        ['/product/view', 'id' => $model->id], 
        ['class' => 'd-flex flex-column align-items-center']) ?>
    </div>
    <div class="mt-3">
      <h5 class="card-title"><?= $model->title ?></h5>
      <p class="card-text fw-bold"><?= $model->price ?> ₽</p>
      <?php if (!isset($model->cartItems[0]) || $model->count > $model->cartItems[0]->product_amount) : ?>
      <div class="mt-2 gap-3">
        <?php if (isset($model->cartItems[0])) : ?>
          <div class="d-flex align-items-center justify-content-center gap-4">
            <span>В корзине</span>
            <div class="d-flex gap-3 align-items-center">
              <?= Html::a('-', ['cart/dec-item', 'item_id' => $model->cartItems[0]->id], 
                ['class' => 'btn btn-outline-warning btn-cart-item-dec text-dark']) ?>
              <?= $model->cartItems[0]->product_amount ?>
              <?= Html::a('+', ['cart/inc-item', 'item_id' => $model->cartItems[0]->id], 
                ['class' => 'btn btn-outline-warning btn-cart-item-inc text-dark']) ?>
            </div>
          </div>
        <?php else : ?>
          <?= ! Yii::$app->user->isGuest && ! Yii::$app->user->identity->isAdmin
            ? Html::a('В корзину', ['cart/add', 'product_id' => $model->id], 
            ['class' => 'btn-cart-add btn btn-warning w-100']) : "" 
          ?>
        <?php endif; ?>
        
      </div>
    <?php else : ?>
      <div class="w-100 mt-2 text-center border border-warning py-2 px-2 rounded-2 mt-3">
        Товар закончился
      </div>
    <?php endif; ?>
    </div>
  </div>
</div>