<?php

use app\models\Product;
use app\models\Status;
use yii\bootstrap5\Html;
?>
<div class="card h-100">
  <div class="border d-flex gap-3 align-items-center justify-content-between p-3">
    <div class="d-flex gap-3">
      <div class="d-flex gap-2 align-items-center">
        <span class="fw-bold">Заказ № <?= $model->id ?></span>
        <span>от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i') ?></span>
      </div>
      <div class="bg-<?= $model->status->bg_color . " text-" . $model->status->text_color ?> py-1 px-2 rounded-3 text-light">
        <?= $model->status->title ?>
      </div>
      <?php
      if ($pickup = $model?->pickUp) {
        echo "<div class='border border-primary text-primary py-1 px-2 rounded-3'>Самовывоз</div>";
      } else {
        echo "<div class='border border-dark text-dark py-1 px-2 rounded-3'>Доставка</div>";
      }
      ?>
    </div>
    <div>
      <?= Html::a('Подробнее', ['view', 'id' => $model->id], ['class' => 'btn btn-outline-dark']) ?>
    </div>

  </div>
  <div class="d-flex gap-4 justify-content-between px-4 py-3">
    <div class="d-flex align-items-center gap-2">
      <?= Html::a(
        Html::img(Product::IMG_PATH . $model->orderItems[0]->product->photo, ['class' => 'w-50']) .
          "<div class='d-flex flex-column align-items-center gap-2'>"
          . $model->orderItems[0]->product->title
          . ((count($model->orderItems) > 1) ? '<span class="text-dark">... и ещё ' . count($model->orderItems) - 1 . '</span>' : '')
          . "</div>",
        ['orders/view', 'id' => $model->id],
        ['class' => 'd-flex align-items-center text-decoration-none']
      ) ?>
    </div>
    <div class="list d-flex flex-column justify-content-center align-items-start gap-2">
      <?php if (isset($model->date_delivery)) {
        echo "
          <div>Дата и время доставки: <div class='fw-bold'>" 
              . Yii::$app->formatter->asDate($model->date_delivery, 'php:d-m-Y')
              . "<span class='ms-3'>" . Yii::$app->formatter->asTime($model->time_delivery, 'php:H:i') .
            "<span></div>
          </div>
        ";
      } else {
        echo '<div>ПВЗ: <span class="fw-bold">' . $model->pickUp->address . '</span></div>';
      }
      ?>
      <div>Сумма: <span class="fw-bold"><?= $model->total_amount ?> ₽</span></div>
      <div>Товаров: <span class="fw-bold"><?= $model->product_amount ?></span></div>
    </div>
  </div>
</div>