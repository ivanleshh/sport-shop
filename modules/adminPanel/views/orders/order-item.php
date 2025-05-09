<?php

use app\models\Product;
use yii\bootstrap5\Html;
use yii\helpers\VarDumper;

?>
<div class="card border rounded-4">
  <div class="card-body row align-items-center">
    <div class="col-12 col-sm-6 col-xxl-6">
      <div class="row align-items-center justify-content-center">
        <?= Html::a(
          Html::img(isset($model->product->productImages[0]->photo) ?
            Product::IMG_PATH . $model->product->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'w-100']),
          ['/product/view', 'id' => $model->product->id],
          ['class' => 'col-5 col-md-8 col-xl-6 col-xxl-4']
        ) ?>
        <?= Html::a(
          $model->product->title,
          ['/product/view', 'id' => $model->product->id],
          ['class' => 'col-6 col-md-12 col-xxl-8 text-decoration-none link-dark fw-bold mt-1 text-center']
        ) ?>
      </div>

    </div>
    <div class="col-12 col-sm-6 col-xxl-6 d-flex flex-column align-items-end text-end gap-2 mt-2">
      <div class="card-cost">Стоимость: <span class="fw-bold text-nowrap"><?= $model->product_cost ?> ₽</span></div>
      <div class="card-cost">Количество: <span class="fw-bold"><?= $model->product_amount ?> </span></div>
      <div class="card-total">Общая стоимость: <span class="fw-bold"><?= $model->total_amount ?> ₽</span></div>
    </div>

  </div>
</div>