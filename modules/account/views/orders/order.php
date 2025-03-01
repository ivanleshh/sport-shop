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
  <div class="card-body d-flex gap-3">
    <div>
        <?= Html::a(
            Html::img(Product::IMG_PATH . $model->orderItems[0]->product->photo, ['class' => 'w-100']),
            ['/product/view', 'id' => $model->orderItems[0]->product->id],
        ) ?>
    </div>
    <div>
        <h5 class="card-title"></h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
    
  </div>
</div>