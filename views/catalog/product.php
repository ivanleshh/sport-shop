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
    <div class="card-img mb-2 border-bottom">
      <?= Html::a(
        Html::img(Product::IMG_PATH . $model->photo, ['class' => 'w-75 h-100']),
        ['/product/view', 'id' => $model->id], 
        ['class' => 'd-flex flex-column align-items-center']) ?>
    </div>
    <div>
      <h5 class="card-title"><?= $model->title ?></h5>
      <p class="card-text fw-bold"><?= $model->price ?> ₽</p>
      <?php if (!isset($model->cartItems[0]) || $model->count > $model->cartItems[0]->product_amount) : ?>
      <div class="w-100 mt-2">
        <?= ! Yii::$app->user->isGuest && ! Yii::$app->user->identity->isAdmin
            ? Html::a('В корзину', ['/cart/add', 'product_id' => $model->id], 
            ['class' => 'w-100 btn-cart-add btn btn-warning']) : "" 
        ?>
      </div>
    <?php else : ?>
      <div class="w-100 mt-2 text-center border border-warning py-2 px-2 rounded-2 mt-3">
        Товар закончился
      </div>
    <?php endif; ?>
    </div>
  </div>
</div>