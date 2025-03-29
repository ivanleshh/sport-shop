<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card d-flex gap-3">
  <div class="card-body d-flex gap-1 justify-content-between">
    <div>
      <?= Html::a(
        Html::img(Product::IMG_PATH . $model->product->photo, ['class' => 'w-100']),
        ['/product/view', 'id' => $model->product->id],
        ['class' => 'd-flex align-items-center text-decoration-none gap-3']
      ) ?>
      <?= Html::a($model->product->title, ['/product/view', 'id' => $model->product->id],
      ['class' => 'd-flex align-items-center text-decoration-none gap-3']) ?>
    </div>
    <div class="d-flex flex-column align-items-end justify-content-center">
      <div class="card-cost d-flex gap-2">Стоимость: <span class="fw-bold"><?= $model->product_cost ?> ₽</span></div>
      <div class="card-cost d-flex gap-2">Количество: <span class="fw-bold"><?= $model->product_amount ?> </span></div>
      <div class="card-total d-flex gap-2">Общая стоимость: <span class="fw-bold"><?= $model->total_amount ?> ₽</span></div>
    </div>

  </div>
</div>