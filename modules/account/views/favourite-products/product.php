<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card" style="width: 18rem; height: 28rem;">
  <div class="card-body d-flex justify-content-between flex-column position-relative">
    <div class="position-absolute top-0 end-0 m-3">
      <?= Html::a(
        '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="red" class="bi bi-trash3-fill" viewBox="0 0 16 16">
          <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
        </svg>',
        ['index', 'id' => $model->id],
        ['data' => ['id' => $model->id, 'pjax' => 0], 'class' => 'btn-favourite text-decoration-none align-self-end']
      ) ?>
    </div>

    <div class="card-img d-flex justify-content-center align-items-center border-bottom h-100">
      <?= Html::a(
        Html::img(Product::IMG_PATH . $model->product->photo, ['class' => 'w-100']),
        ['/product/view', 'id' => $model->product->id],
        ['class' => 'd-flex flex-column align-items-center w-75']
      ) ?>
    </div>
    <div class="mt-3">
      <h5 class="card-title"><?= Html::encode($model->product->title) ?></h5>
      <p class="card-text fw-bold"><?= $model->product->price ?> ₽</p>
      <?php if (!isset($model->product->cartItems[0]) || $model->product->count > $model->product->cartItems[0]->product_amount) : ?>
        <div class="mt-2 gap-3">
          <?php if (isset($model->product->cartItems[0])) : ?>
            <div class="d-flex align-items-center justify-content-center gap-4">
              <span>В корзине</span>
              <div class="d-flex gap-3 align-items-center">
                <?= Html::a(
                  '-',
                  ['/cart/dec-item', 'item_id' => $model->product->cartItems[0]->id],
                  ['class' => 'btn btn-outline-warning btn-cart-item-dec text-dark']
                ) ?>
                <?= $model->product->cartItems[0]->product_amount ?>
                <?= Html::a(
                  '+',
                  ['/cart/inc-item', 'item_id' => $model->product->cartItems[0]->id],
                  ['class' => 'btn btn-outline-warning btn-cart-item-inc text-dark']
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
      <?php else : ?>
        <div class="w-100 mt-2 text-center border border-warning py-2 px-2 rounded-2 mt-3">
          Товар закончился
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>