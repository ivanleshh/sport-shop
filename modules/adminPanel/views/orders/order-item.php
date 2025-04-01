<?php

use app\models\Product;
use yii\bootstrap5\Html;
use yii\helpers\VarDumper;

?>
<div class="card border rounded-4">
  <div class="card-body row align-items-center">
    <div class="col-12 col-sm-6 text-center">
      <div class="row justify-content-center">
        <?= Html::a(
          Html::img(isset($model->product->productImages[0]->photo) ?
            Product::IMG_PATH . $model->product->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'w-75']),
          ['/product/view', 'id' => $model->product->id],
          ['class' => 'col-8']
        ) ?>
        <?= Html::a(
          $model->product->title,
          ['/product/view', 'id' => $model->product->id],
          ['class' => 'col-12 text-decoration-none fw-bold mt-1']
        ) ?>
      </div>

    </div>
    <div class="col-12 col-sm-6 d-flex flex-column align-items-center justify-content-center text-end gap-2 mt-2">
      <div class="card-cost">Стоимость: <span class="fw-bold"><?= $model->product_cost ?> ₽</span></div>
      <div class="card-cost">Количество: <span class="fw-bold"><?= $model->product_amount ?> </span></div>
      <div class="card-total">Общая стоимость: <span class="fw-bold"><?= $model->total_amount ?> ₽</span></div>
    </div>

  </div>
</div>