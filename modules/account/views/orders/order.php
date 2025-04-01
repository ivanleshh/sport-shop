<?php

use app\models\Product;
use app\models\Status;
use yii\bootstrap5\Html;
?>
<div class="card h-100 rounded-4">
  <div class="border-bottom d-flex gap-2 align-items-center justify-content-between p-3">
    <div class="d-flex gap-2 align-items-center">
      <span class="fw-bold">Заказ № <?= $model->id ?></span>
      <span>от <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i') ?></span>
    </div>
    <div class="bg-<?= $model->status->bg_color ?> px-3 py-2 rounded-3 text-nowrap">
      <?= $model->status->title ?>
    </div>
  </div>
  <div class="row justify-content-center justify-content-sm-evenly align-items-center p-3">
    <div class="col-7 col-sm-5 col-md-8 col-lg-6">
      <?= Html::a(
        Html::img(isset($model->orderItems[0]->product->productImages[0]) ?
          Product::IMG_PATH . $model->orderItems[0]->product->productImages[0]->photo : Product::NO_PHOTO, ['class' => 'col-12 col-md-6 col-lg-12 h-100 h-sm-auto']) .
          "<div class='col-12 col-md-6 col-lg-12 my-2 fw-bold'>"
          . $model->orderItems[0]->product->title
          . ((count($model->orderItems) > 1) ? '<span class="text-dark text-break"> ... и ещё ' . count($model->orderItems) - 1 . '</span>' : '')
          . "</div>",
        ['orders/view', 'id' => $model->id],
        ['class' => 'row align-items-center text-decoration-none text-center']
      ) ?>
    </div>
    <div class="col-12 col-sm-7 col-md-4 col-lg-6 mt-2 list d-flex flex-column align-items-center justify-content-between gap-2">
      <?php if (isset($model->date_delivery)) {
        echo "
          <div>Дата и время доставки: <div class='fw-bold text-end'>"
          . Yii::$app->formatter->asDate($model->date_delivery, 'php:d-m-Y')
          . "<span class='ms-2'>" . Yii::$app->formatter->asTime($model->time_delivery, 'php:H:i') .
          "<span></div>
          </div>
        ";
      } else {
        echo '<div class="text-center">ПВЗ: <span class="fw-bold">' . $model->pickUp->address . '</span></div>';
      }
      ?>
      <div>Сумма: <span class="fw-bold"><?= $model->total_amount ?> ₽</span></div>
      <div>Товаров: <span class="fw-bold"><?= $model->product_amount ?></span></div>
    </div>
  </div>
</div>