<?php

use app\models\Product;
use yii\bootstrap5\Html;
?>
<div class="card">
  <div class="card-header d-flex gap-4 align-items-center">
    <div class="d-flex gap-2 align-items-center">
        <span class="fw-bold">Заказ № <?= $model->id ?></span>
        <span>от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i') ?></span>
    </div>
    <div class="bg-<?= $model->status->color ?> py-1 px-2 rounded-3">
        <?= $model->status->title ?>
    </div>
  </div>
  <div class="card-body d-flex gap-3 justify-content-between">
    <div class="d-flex align-items-center gap-2">
        <div>
          <?= Html::a(
            Html::img(Product::IMG_PATH . $model->orderItems[0]->product->photo, ['class' => 'w-50']) .
            "<div class='d-flex flex-column align-items-center gap-2'>"
              . $model->orderItems[0]->product->title
              . ((count($model->orderItems) > 1) ? '<span class="text-dark">... и ещё ' . count($model->orderItems)-1 . '</span>' : '')
            . "</div>",
            ['orders/view', 'id' => $model->id],
            ['class' => 'd-flex align-items-center text-decoration-none']
        ) ?>
        </div>
    </div>
    <div class="d-flex flex-column align-items-end justify-content-center">
        <h6 class="card-title">Сумма заказа: <span class="fw-bold"><?= $model->total_amount ?> ₽</span></h6>
        <span class="card-text mb-3">Количество товаров: <?= $model->product_amount ?></span>
        <?= Html::a('Подробнее', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-dark']) ?>
    </div>
    
  </div>
</div>